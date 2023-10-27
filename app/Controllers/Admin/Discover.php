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

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GenreModel;
use CodeIgniter\Model;

class Discover extends BaseController
{

    protected $dataApi;

    public function __construct()
    {
        $this->dataApi = service('data_api');
    }

    public function movies()
    {
        $title = 'Discover Movies';

        $genres = $this->dataApi->getGenres('movie');
        $langList = $this->dataApi->getLangList();
        $langList = array_merge([ '' => '' ], $langList);

        $topBtnGroup = create_top_btn_group([
            'admin/discover/shows' => 'Discover TV Shows'
        ]);

        return view('admin/discover/movies',
            compact('title','langList', 'genres', 'topBtnGroup'));
    }


    public function shows()
    {
        $title = 'Discover TV Shows';

        $genres = $this->dataApi->getGenres('tv');

        $langList = $this->dataApi->getLangList();
        $langList = array_merge([ '' => '' ], $langList);

        $topBtnGroup = create_top_btn_group([
            'admin/discover/movies' => 'Discover Movies'
        ]);

        return view('admin/discover/series',
            compact('title','langList', 'genres', 'topBtnGroup'));
    }


}
