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
use App\Models\MovieModel;

class Home extends BaseController
{

    public function index()
    {

        $title = ! empty( get_config( 'site_title' ) )  ? get_config( 'site_title' ) : 'Home';
        $metaKeywords = create_keywords_list(get_config('site_keywords'));
        $metaDescription = get_config('site_description');

        $movieModel = new MovieModel();
        $trendingMovies = [];
        $latestMovies = $latestMovies = $latestShows = [];


        //recently movies
        if(! empty( get_config('home_latest_movies_per_page') )){

            $latestMovies = $movieModel->orderBy('movies.id', 'desc')
                                       ->limit( get_config('home_latest_movies_per_page') )
                                       ->forView()
                                       ->movies()
                                       ->allMovies()
                                       ->find();
        }

        //recently shows
        if(! empty( get_config('home_latest_shows_per_page') )){

            $latestShows = $movieModel->orderBy('movies.id', 'desc')
                                       ->limit( get_config('home_latest_shows_per_page') )
                                       ->forView()
                                       ->allMovies()
                                       ->episodes()
                                       ->find();
        }


        $activeMovie = ! empty( $latestMovies ) ? $latestMovies[0] : null;

        //trending movies
        if(! empty( get_config('home_trending_movies_per_page') ) ){

            $trendingMovies = $movieModel->limit(get_config('home_trending_movies_per_page'))
                                         ->getTrendingList();

        }

        //trending shows
        if(! empty( get_config('home_trending_shows_per_page') ) ){

            $trendingShows = $movieModel->limit(get_config('home_trending_shows_per_page'))
                                        ->getTrendingList(false);

        }



        if($activeMovie == null){

            $activeMovie = $movieModel->episodes()
                                      ->orderBy('id', 'desc')
                                      ->first();

        }

        //ads codes
        $adsModel = new AdsModel();
        $ads = $adsModel->forView()
                        ->getAds('home');

        // cache page
        $this->cacheIt('home');

        $data = compact('latestMovies', 'latestShows', 'trendingMovies', 'trendingShows', 'activeMovie', 'ads',
            'title', 'metaKeywords', 'metaDescription');

        return view(theme_path('home'), $data);
    }
}