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
use App\Models\LinkModel;
use App\Models\MovieModel;
use App\Models\SeasonModel;
use App\Models\SeriesModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Model;


class View extends Embed
{


    public function view( $uniqId, $sea = null, $epi = null )
    {

        // Default keywords
        $defaultKeywords = ['stream', 'play now'];

        // Attempt to view with general id
        if($tmpId = $this->getDirectGeneralId( $uniqId )){
            $uniqId = $tmpId;
            $this->reqUniqIdSource = 'id';
        }

        $title = '';
        $movie = $links = $seasons = null;
        $metaKeywords = $metaDescription = '';


        if( $this->validateInputData( $uniqId, $sea, $epi ) ){

            $activeMovie = $this->getMovie( $uniqId, $sea, $epi);

            if($activeMovie !== null){

                // movie title and meta data
                $title = lang('Watch') . " {$activeMovie->getMovieTitle()}";
                $metaKeywords = create_keywords_list($activeMovie->meta_keywords, $activeMovie->getMovieTitle());
                $metaDescription = $activeMovie->meta_description;


                if(get_config('movie_desc_as_meta') && empty($metaDescription) ) {
                    $metaDescription = substr($activeMovie->description, 0, 160);
                }


                if($activeMovie->isEpisode()){

                    $seasonModel = new SeasonModel();
                    $seasons = $seasonModel->withEpisodes()
                                           ->findBySeriesId( $activeMovie->series_id );

                }

                //save in recommend
                service('recommend')->detect( $activeMovie );

            }else{

                throw new PageNotFoundException();

            }

        }

        //ads codes
        $adsModel = new AdsModel();
        $ads = $adsModel->forView()
                        ->getAds('view');

        // cache page
        $this->cacheIt('view');

        if(empty( $activeMovie )){

            throw new PageNotFoundException();

        }

        $data = compact('activeMovie', 'seasons', 'ads', 'metaKeywords', 'metaDescription', 'title');

        return view( theme_path('view') , $data);
    }




}