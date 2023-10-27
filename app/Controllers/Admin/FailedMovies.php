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

class FailedMovies extends BaseController
{

    /**
     * @var \App\Models\FailedMovies
     */
    protected $model;

    public function __construct()
    {
        $this->model = new \App\Models\FailedMovies();
    }

    public function index()
    {
        $title = 'Next For You';

        $movies = $this->model->orderBy('updated_at','desc')
                              ->orderBy('requests', 'desc')
                              ->findAll();

        $title .= ' - ( ' . count( $movies ) . ' )';

        return view('admin/failed_movies/list', compact('title','movies'));
    }

    public function delete()
    {
        $id = $this->request->getGet('id');

        if(! empty($id) && is_numeric($id)){

            $this->model->delete( $id );

        }

        return redirect()->back()
                         ->with('success', 'Record deleted successfully');

    }



}