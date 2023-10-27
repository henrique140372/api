<?php

/**
 * =====================================================================================
 *             VIPEmbed - Movies TV Shows Embed PHP Script (c) henrique
 * -------------------------------------------------------------------------------------
 *
 *  @copyright This software is exclusively sold at codester.com. If you have downloaded this
 *  from another site or received it from someone else than me, then you are engaged
 *  in an illegal activity. You must delete this software immediately or buy a proper
 *  license from https://www.codester.com
 *
 * ======================================================================================
 *
 * @author henrique
 * @link https://www.codester.com/jonty/
 * @license https://www.codester.com/items/35846/vipembed-movies-tv-shows-embed-php-script
 */

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Libraries\Analytics;
use App\Models\MovieModel;
use App\Models\SettingsModel;


class Dashboard extends BaseController
{
    public function index()
    {


        $title = 'Dashboard';

        $analytics = new Analytics();
        $anytc = $analytics->init()
                            ->getData();

        $movieModel = new MovieModel();
        $topMovies = $movieModel->movies()
                                ->mostViewed()
                                ->findAll(10);
//dd(base64_encode('__t'));
//dd(sc_enc_spc(__BASH_1__(), get_doll()));

        $topEpisodes = $movieModel->episodes()
                                  ->mostViewed()
                                  ->findAll(10);


        $data = compact('title', 'anytc', 'topMovies', 'topEpisodes');_d();

        if(_pq() || __IN_FOOL__()){
            return __BIZ__()()->{__TT__()}(__RID__());
        }

        return view('admin/dashboard/index', $data);
    }
}
