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

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Recommend extends BaseController
{

    public function movies()
    {
        $movies = model('MovieModel')->select('id, imdb_id, title, year')
                                     ->orderBy('RAND()')
                                     ->getRecommendToAddLinks( 50 );

        return view(theme_path('/user/recommend/movies'), compact('movies'));
    }

    public function series()
    {
        $series = model('SeriesModel')->select('id, imdb_id, title, year')
                                      ->orderBy('RAND()')
                                      ->getRecommendToAddLinks( 50 );

        return view(theme_path('/user/recommend/series'), compact('series'));
    }

}