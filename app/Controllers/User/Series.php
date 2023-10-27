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
use App\Models\SeriesModel;
use CodeIgniter\Exceptions\PageNotFoundException;


class Series extends BaseController
{

    protected $model;

    public function __construct()
    {
        $this->model = new SeriesModel();
    }


    public function view( $id )
    {

        $series = $this->getSeries( $id );
        $title = $series->title;

        $seasons = model('SeasonModel')->withEpisodes()
                                       ->findBySeriesId( $series->id );


        $seasons = create_episode_meta_list( $seasons );

        return view(theme_path('user/series'),
            compact('title','series', 'seasons'));
    }

    protected function getSeries( $id )
    {
        $series = null;
        if($id = decode_id($id)){
            $series = $this->model->getSeries( $id );
        }

        if($series === null){
            throw new PageNotFoundException('series not found');
        }

        return $series;
    }
}
