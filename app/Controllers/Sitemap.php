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

use App\Controllers\BaseController;
use App\Models\MovieModel;
use CodeIgniter\Model;

class Sitemap extends BaseController
{

    protected $itemsPerPage = 1;

    protected $model;

    public function __construct()
    {
        $this->model = new MovieModel();
    }

    public function index()
    {
        $this->response->setHeader('Content-Type', 'text/xml;charset=iso-8859-1');

        $urls = [
            site_url('/sitemap/main.xml'),
            site_url('/sitemap/movies/view.xml'),
            site_url('/sitemap/series/view.xml'),
            site_url('/sitemap/movies/download.xml'),
            site_url('/sitemap/series/download.xml'),
        ];

        return view('sitemap/index', compact('urls'));
    }


    public function get_view_items($t = null)
    {
        $this->response->setHeader('Content-Type', 'text/xml;charset=iso-8859-1');
        $items = $this->getItems($t);

        if(! isset($_GET['page'])){

            $pageCount = $this->model->pager->getPageCount();
            $urls = [];

            if(! empty($pageCount)){

                for ($i=1;$i <=  $pageCount; $i++) {
                    $urls[] = site_url("/sitemap/{$t}/view.xml?page={$i}");
                }

            }

            return view('sitemap/index', compact('urls'));
        }

        return view('sitemap/view-items', compact('items'));
    }

    public function get_dl_items($t = null)
    {
        $this->response->setHeader('Content-Type', 'text/xml;charset=iso-8859-1');
        $items = $this->getItems($t);

        if(! isset($_GET['page'])){

            $pageCount = $this->model->pager->getPageCount();
            $urls = [];

            if(! empty($pageCount)){

                for ($i=1;$i <=  $pageCount; $i++) {
                    $urls[] = site_url("/sitemap/{$t}/download.xml?page={$i}");
                }

            }

            return view('sitemap/index', compact('urls'));
        }

        return view('sitemap/dl-items', compact('items'));
    }

    public function main_pages()
    {
        $dailyUpdates = $this->getMainDailyUpdatedPages();
        $this->response->setHeader('Content-Type', 'text/xml;charset=iso-8859-1');
        return view('sitemap/main', compact('dailyUpdates'));
    }


    protected function getItems($t)
    {
        $t == 'movies' ? $this->model->movies()->select('movies.*') : $this->model->episodes();
        return  $this->model->allMovies([], false)
                              ->forView()
                              ->paginate($this->itemsPerPage);
    }


    protected function getEpisodes()
    {
        $movieModel = new MovieModel();
        return  $movieModel->episodes()
                            ->allMovies()
                            ->forView()
                            ->findAll();
    }

    protected function getMainDailyUpdatedPages(): array
    {
        return [
            library_url(),
            library_url([], 'shows'),
            site_url('/trending/movies'),
            site_url('/trending/shows'),
            site_url('/recommend/movies'),
            site_url('/recommend/shows'),
            site_url('/recent-releases/movies'),
            site_url('/recent-releases/shows'),
            site_url('/imdb-top/movies'),
            site_url('/imdb-top/shows')
        ];
    }

}
