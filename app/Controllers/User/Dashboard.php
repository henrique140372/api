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
use App\Libraries\UserAnalytics;

class Dashboard extends BaseController
{
    public function index()
    {
        $title = lang("User/Dashboard.dashboard");

        $userAnalytics = new UserAnalytics(get_current_user_id());
        $userAnalytics->init();

        $analytics = $userAnalytics->getData(true);


        $recommendMovies = model('MovieModel')->select('id, imdb_id, type, title, year')
                                              ->orderBy('RAND()')
                                              ->getRecommendToAddLinks( 10 );

        $recommendSeries = model('SeriesModel')->select('id, imdb_id, title, year')
                                               ->orderBy('RAND()')
                                               ->getRecommendToAddLinks( 10 );

        return view(theme_path('user/dashboard'),
            compact('title', 'analytics', 'recommendMovies', 'recommendSeries'));
    }
}