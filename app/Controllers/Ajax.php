<?php

/**
 * =====================================================================================
 *             VIPEmbed - Movies TV Shows Embed PHP Script (c) John Antonio
 * -------------------------------------------------------------------------------------
 *
 *  @copyright This software is exclusively sold at codester.com. If you have downloaded this
 *  from another site or received it from someone else than me, then you are engaged
 *  in an illegal activity. You must delete this software immediately or buy a proper
 *  license from https://www.codester.com
 *
 * ======================================================================================
 *
 * @author John Antonio
 * @link https://www.codester.com/jonty/
 * @license https://www.codester.com/items/35846/vipembed-movies-tv-shows-embed-php-script
 */

namespace App\Controllers;


use App\Libraries\ReqIdentity;
use App\Libraries\UniqToken;
use App\Libraries\UniqVisit;
use App\Libraries\VisitorInfo\BrowserDetection;
use App\Models\LinkModel;
use App\Models\MovieModel;
use App\Models\SeriesModel;
use App\Models\VisitorsModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;


class Ajax extends BaseAjax
{

    public function get_stream_link()
    {

        //validate captcha
        if(get_config('is_stream_gcaptcha_enabled') ){

            helper('captcha');

            $success = false;
            $captchaResponse = $this->request->getGet('captcha');

            if(! empty($captchaResponse)){
                if(validate_gcaptcha( $captchaResponse )){
                    $success = true;
                }
            }

            if(! $success){

                $this->addError('Captcha validate failed. try again');
                return $this->jsonResponse();

            }

        }


        $linkId = decode_id( $this->request->getGet( 'id' ) );
        $movieId = decode_id( $this->request->getGet( 'movie' ) );
        $refUser = $this->request->getGet('ref');

        $validation = service('validation');
        if( $validation->check($linkId, 'required|is_natural_no_zero|exist[links.id]')
            && $validation->check($movieId, 'required|is_natural_no_zero|exist[links.movie_id]')){

            $linkModel = new LinkModel();
            $link = $linkModel->where('id', $linkId)
                              ->where('movie_id', $movieId)
                              ->where('type', 'stream')
                              ->first();

            if($link !== null){

                //update request in the link
                $linkModel->updateRequests( $link->id );
                $this->addData( ['link' => $link->link] );

                /*
                 * if this is first request, we will attempt to update
                 * requests in the movies/episodes
                 * */
                if($this->request->getGet('is_init') == 'false'){

                    $movieModel = new MovieModel();
                    $movie = $movieModel->getMovie( $link->movie_id );


                    //add cookie based uniq view
                    if(! UniqVisit::isViewed( $movie->imdb_id )) {
                        UniqVisit::viewed( $movie->imdb_id );
                    }

                    //save in watch history
                    service('watch_history')->add( $movie->id )->save();

                    //save in recommend
                    if( is_web_page_cache_enabled() ){
                        service('recommend')->detect( $movie );
                    }


                    //played callback token
                    $playedToken = [$movieId, $refUser, UniqVisit::setUniqToken()];
                    $playedToken = UniqToken::create( $playedToken );
                    if($playedToken !== null){
                        $this->addData(['_played' => $playedToken]);
                    }

                }

                //set active link token
                $tokenData = [ 'stream_link', $link->id ];
                $token = UniqToken::create( $tokenData );

                if($token !== null){
                    $this->addData(['token' => $token]);
                }


            }

        }

        return $this->jsonResponse();

    }

    public function report_download_link()
    {

        if(! is_links_report_enabled() ) {

            throw new PageNotFoundException('report system not enabled');

        }

        $token = $this->request->getGet('token');
        $isNotWorking = $this->request->getGet('reason') == 'not_working';

        $linkId = $movieId = 0;

        //decode token
        if($tokenData = UniqToken::decode( $token )){
            list($movieId, $linkId) = $tokenData;
            //validate link id
            if(! is_numeric( $linkId ) || $linkId <= 0){
                $linkId = 0;
            }
        }


        if(! empty($linkId)){

            $linkModel = new LinkModel();

            //get link
            $link = $linkModel->getLink( $linkId );
            if($link !== null && $link->movie_id == $movieId){

                //identity user request
                $reqIdentity = new ReqIdentity( $linkId );
                if($reqIdentity->isNew()){

                    $linkModel = new LinkModel();
                    $linkModel->where('type !=', 'stream')
                              ->report( $linkId, $isNotWorking );

                    $this->success();

                    //detect user request identity
                    $reqIdentity->detect();

                }else{

                    $this->addError('already reported');

                }

            }

        }


        return $this->jsonResponse();
    }

    public function report_stream_link()
    {
        if(! is_links_report_enabled() ) {

            throw new PageNotFoundException('report system not enabled');

        }

        //validate token
        $token = $this->request->getGet('token');
        $isNotWorking = $this->request->getGet('reason') == 'not_working';

        if($tokenData = UniqToken::decode( $token )){

            if(count( $tokenData ) == 2) {

                list($label, $linkId) = $tokenData;

                $validation = service('validation');

                if($validation->check($linkId, 'required|is_natural_no_zero|exist[links.id]')
                    && $label == 'stream_link') {

                    $reqIdentity = new ReqIdentity( $linkId );
                    if($reqIdentity->isNew()){

                        $linkModel = new LinkModel();
                        $linkModel->where('type', 'stream')
                                  ->report( $linkId, $isNotWorking);

                        $this->success();
                        $reqIdentity->detect();

                    }else {

                        $this->addError('already reported');

                    }


                }else{

                    $this->addError( 'data validation failed' );

                }

            }

        }else{

            $this->addError('Invalid Token');

        }

        return $this->jsonResponse();
    }

    public function get_suggest()
    {
        $title = $this->request->getGet('title');
        $type = $this->request->getGet('type');
        $content = '';

        if(! empty($title)){

            $tmdb = service('tmdb');
            $results = $tmdb->translate()
                            ->search( $title, $type );


            if(! empty( $results )){

                $movieModel = new MovieModel();
                $seriesModel = new SeriesModel();

                foreach ($results as $key => $val) {

                    $results[$key]['is_exist'] = false;

                    if($type == 'movie'){
                        $movie = $movieModel->select('movies.id')
                                            ->movies()
                                            ->getMovieByUniqId( $val['tmdb_id'], 'tmdb_id', false );
                    }else{
                        $movie = $seriesModel->select('id')
                                             ->getSeriesByTmdbId($val['tmdb_id']);
                    }

                    if($movie !== null){
                        $results[$key]['is_exist'] = true;
                    }
                }

                ob_start();

                foreach ($results as $result) {
                    echo '<div class="col-6 col-lg-3 px-5">';
                    the_req_movie_item( $result );
                    echo '</div>';
                }

                $content .= ob_get_clean();

            }

            $this->addData( ['results' => $content] );
        }

        return $this->jsonResponse();
    }

    public function played()
    {
        if(! is_views_analytics_system_enabled() &&
            ! is_ref_rewards_system_enabled()){
                return null;
        }

        $token = $this->request->getGet('token');
        if($tokenData = UniqToken::decode( $token )){
            if(count($tokenData) == 3){

                list($movieId, $refUser, $uniqVisitToken) = $tokenData;

                #01: Check uniq visit token
                if(! UniqVisit::isValidUniqToken( $uniqVisitToken, true)){
                    return;
                }

                #02: Check movie id and get it
                $movie = model('MovieModel')->getMovie( $movieId );
                if($movie === null){
                    return;
                }

                #03: Attempt to add view
                model('VisitorsModel')->addVisit($movie->id, $refUser);

            }
        }

        return;
    }

}