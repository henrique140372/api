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

use App\Models\AdsModel;
use App\Models\FailedMovies;
use App\Models\LinkModel;
use App\Models\MovieGenreModel;
use App\Models\MovieModel;
use App\Models\SeriesGenreModel;
use App\Models\SeriesModel;
use App\Models\TranslationsModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Model;


class Embed extends BaseController
{

    protected $reqDataType = null;
    protected $reqUniqIdSource = null;
    protected $justTv = false;


    public function __construct()
    {
        $this->helpers[] = 'unique_views';
    }

    public function view( $uniqId, $sea = null, $epi = null )
    {
        // Attempt to view with general id
        if($tmpId = $this->getDirectGeneralId( $uniqId )){
            $uniqId = $tmpId;
            $this->reqUniqIdSource = 'id';
        }

        $movie = $links = null;
        $serverNotFound = false;
        $server = $this->request->getGet('server');

        if($this->validateInputData( $uniqId, $sea, $epi )){

            $movieModel = new MovieModel();
            $movie = $this->getMovie( $uniqId, $sea, $epi);

            if($movie !== null){

                $linkModel = new LinkModel();
                $links = $linkModel->forView()
                                   ->findByMovieId( $movie->id, 'stream', false);

                if(! empty( $links )){

                    $links = create_stream_servers_list( $links );

                    if($this->request->getGet('load-server') == 1){

                        //load server randomly
                        $randLink = $links[array_rand($links)];
                        return redirect()->to( $movie->getEmbedLink(true) . '?server=' . $randLink);

                    }

                    //check single server request
                    if(! empty($server)){

                        $defServer = array_search($server, $links);
                        if(! empty($defServer)) {

                            $links = [ $defServer => $links[$defServer] ];

                        }else{
                            $serverNotFound = true;
                            $links = [];
                        }

                    }

                }

            }

        }

        //ads codes
        $adsModel = new AdsModel();
        $ads = $adsModel->forView()
                        ->getAds('embed');

        $this->cacheIt('embed');

        $data = compact('movie', 'links', 'serverNotFound', 'ads');
        return view(theme_path( 'embed' ), $data);
    }


    public function getMovie($uniqId, $sea = null, $epi = null)
    {
        $movieModel = new MovieModel();

        $movie = null;
        switch ($this->reqUniqIdSource) {
            case 'id':
                if(! $this->justTv){
                    $movie = $movieModel->getMovieByUniqId( $uniqId, 'id');
                }
                break;
            case 'imdb':
                $movie = $movieModel->getMovieByImdbId( $uniqId );
                break;
            case 'tmdb':
                $movie = $movieModel->getMovieByTmdbId( $uniqId );
                break;
            default:
                $movie = $movieModel->getMovieByUniqId( $uniqId );
        }

        $series = null;

        if($movie === null){

            //find series
            $seriesModel = new SeriesModel();

            switch ($this->reqUniqIdSource) {
                case 'id':
                    $series = $seriesModel->getSeries( $uniqId );
                    break;
                case 'imdb':
                    $series = $seriesModel->getSeriesByImdbId( $uniqId );
                    break;
                case 'tmdb':
                    $series = $seriesModel->getSeriesByTmdbId( $uniqId );
                    break;
                default:
                    $series = $seriesModel->getSeriesByUniqId( $uniqId );
            }

        }else{
            if(! empty($movie->series_id) && ($sea > 1 || $epi > 1)){
                $seriesModel = new SeriesModel();
                $series = $seriesModel->getSeries( $movie->series_id );
            }
        }

        if($series !== null){

            //get episode
            $movie = $movieModel->getEpisode( $series->id, $sea, $epi );

        }

        if(! empty($movie)){

            //check movie is public
            if($movie->status != 'public'){
                throw new PageNotFoundException("Movie or episode is not public");
            }

            //filter
            if(! empty($this->reqDataType)){
                if($this->reqDataType == 'movie' && $movie->isEpisode()){
                    $movie = null;
                }
                if($this->reqDataType == 'series' && ! $movie->isEpisode()){
                    $movie = null;
                }
            }


        }else{

            $this->trackRequest( $uniqId, $sea, $epi );

        }

        return $movie;


    }

    public function movie()
    {
        $uniqId = null;

        $imdbId = $this->request->getGet( 'imdb' );
        $tmdbId = $this->request->getGet( 'tmdb' );
        $generalId = $this->request->getGet( 'id' );

        $title = $this->request->getGet('title');
        $year = $this->request->getGet('year');

        if(empty($title)){
            if(! empty($imdbId)){
                $this->reqUniqIdSource = 'imdb';
                $uniqId = $imdbId;
            }else if(! empty($tmdbId)){
                $this->reqUniqIdSource = 'tmdb';
                $uniqId = $tmdbId;
            }else{
                $uniqId = $generalId;
            }
        }else{
            //search by title
            $movieModel = new MovieModel();

            if(! empty($year)){
                $movieModel->where('year', $year);
            }

            $results = $movieModel->join('movie_translations as translations', 'translations.movie_id = movies.id', 'LEFT')
                                    ->groupStart()
                                    ->like('movies.title', $title, 'both', null, true)
                                        ->orGroupStart()
                                            ->where('lang', current_language())
                                            ->like('translations.title', $title, 'both', null, true)
                                        ->groupEnd()
                                   ->groupEnd()
                                   ->first();

            if($results !== null){
                $uniqId = $results->imdb_id;
            }
        }

        $this->reqDataType = 'movie';
        return $this->view( $uniqId );
    }

    public function series()
    {
        $uniqId = null;

        $imdbId = $this->request->getGet( 'imdb' );
        $tmdbId = $this->request->getGet( 'tmdb' );
        $season = $this->request->getGet( 'sea' );
        $episode = $this->request->getGet( 'epi' );
        $generalId = $this->request->getGet( 'id' );

        $title = $this->request->getGet('title');
        $year = $this->request->getGet('year');

        if(empty($title)){

            if(! empty($imdbId)){
                $this->reqUniqIdSource = 'imdb';
                $uniqId = $imdbId;
            }elseif(! empty($tmdbId)){
                $this->reqUniqIdSource = 'tmdb';
                $uniqId = $tmdbId;
            }else{
                $uniqId = $generalId;
            }

        }else{

            //search by title
            $seriesModel = new SeriesModel();

            if(! empty($year)){
                $seriesModel->where('year', $year);
            }

            $results = $seriesModel->like('title', $title)
                                   ->first();
            if($results !== null){
                $uniqId = $results->imdb_id;
            }

        }


        $this->reqDataType = 'series';
        return $this->view( $uniqId, $season, $episode );
    }


    protected function getDirectGeneralId( $uniqId )
    {
        if(empty($uniqId)){
            return false;
        }

        if(is_movies_dynamic_slug_enabled()){
            $tmpUniqId = extract_uniq_id_from_slug( $uniqId );

            if(! empty($tmpUniqId) && strpos($tmpUniqId, '-') !== false){
                $tmpUniqId = str_replace('-', '', $tmpUniqId);
                $this->justTv = true;
            }
        }

        if(empty($tmpUniqId) && ! is_valid_movie_id($uniqId)){
            $tmpUniqId = decode_id( $uniqId );
        }

        if(! empty($tmpUniqId) && is_numeric( $tmpUniqId )){

            return $tmpUniqId;

        }

        return false;
    }

    protected function validateInputData($uniqId, $sea, $epi)
    {
        $validationRules = [
            'uniqId' => 'required',
            'sea' => 'permit_empty|is_natural_no_zero',
            'epi' => 'permit_empty|is_natural_no_zero',
        ];
        if($this->reqUniqIdSource != 'id'){
            $validationRules['uniqId'] .= '|valid_movie_id';
        }

        $validation = service('validation');
        $validation->setRules( $validationRules );

        $data = [
            'uniqId' => $uniqId,
            'sea' => $sea,
            'epi' => $epi
        ];

        return $validation->run($data);
    }

    protected function trackRequest( $uniqId, $sea = null, $epi = null )
    {

        $failedMovies = new FailedMovies();

        //check record is already exist
        $failedMovie = $failedMovies->where('type !=', 'series')->findByReqId( $uniqId );
        if($failedMovie !== null) {

            //add request
            if(! is_movie_viewed( $failedMovie['imdb_id'] )){
                $failedMovies->updateRequests( $failedMovie['id'] );
                movie_viewed( $failedMovie['imdb_id'] );
            }

            return;

        }

        $tmdb = service('tmdb');
        $result = null;

        if(isValidImdbId( $uniqId )) {

            //get data from imdb id
            $result = $tmdb->findByImdbId( $uniqId );


        }else{

            if(! empty($this->reqDataType)){

                $isMovie = ( $this->reqDataType == 'movie' );
                $result = $isMovie ? $tmdb->getMovie( $uniqId ) : $tmdb->getTv( $uniqId );

                if(! $isMovie && $result !== null){

                    if(! empty($sea) && ! empty($epi)){

                        $result = $tmdb->getEpisode( $uniqId, $sea, $epi );

                        if($result !== null){

                            $failedMovie = $failedMovies->findByReqId( $result->imdb_id );
                            if($failedMovie !== null) {

                                //add request
                                if(! is_movie_viewed( $failedMovie['imdb_id'] )){
                                    $failedMovies->updateRequests($failedMovie['id']);
                                    movie_viewed( $failedMovie['imdb_id'] );
                                }

                                return;

                            }


                        }

                    }

                }

            }

        }

        if($result !== null){

            $data = [
                'title'    => $result->title,
                'type'     => $result->type,
                'imdb_id'  => $result->imdb_id,
                'tmdb_id'  => $result->tmdb_id
            ];

            //add request
            if(! is_movie_viewed( $result->imdb_id )){
                movie_viewed( $result->imdb_id );
            }

            $failedMovies->insert( $data );

        }

    }







}