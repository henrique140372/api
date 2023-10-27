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
use App\Models\LinkModel;
use App\Models\MovieModel;
use CodeIgniter\Model;


class Movies extends BaseController
{

    protected $model;

    public function __construct()
    {
        $this->model = new MovieModel();
    }


    public function view_all( $t = 'movie' )
    {

        $isMovie = $t == 'movie';

        $title = $isMovie ? 'My Movies' : 'My TV Shows';
        $isMovie ? $this->model->movies() : $this->model->episodes(false, false);

        $selection = $isMovie ? 'movies.id, movies.title, movies.imdb_id, movies.year' : 'series.id, series.imdb_id, series.title, series.year';
        $groupBy = $isMovie ? 'movies.id' : 'series.id';

        $movies = $this->model->join('links', 'links.movie_id = movies.id', 'LEFT')
                              ->where('links.user_id', get_current_user_id())
                              ->orderBy('links.id', 'DESC')
                              ->groupBy( $groupBy )
                              ->select( $selection )
                              ->find();

        $data = compact('movies', 'isMovie', 'title');
        return view( theme_path("/user/movies/my_list"), $data);
    }

}