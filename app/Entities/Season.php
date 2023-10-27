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

namespace App\Entities;

use App\Models\SeriesModel;
use CodeIgniter\Entity\Entity;
use CodeIgniter\Model;


class Season extends \CodeIgniter\Entity\Entity
{

    public $series = null;


    public function series()
    {
        if($this->series === null){

            $this->series = new Series();

            $seriesModel = new SeriesModel();
            $series = $seriesModel->where('id', $this->series_id)
                                  ->first();
            if(! empty($series)){
                $this->series = $series;
            }

        }

        return  $this->series;

    }

    public function episodes()
    {
        return is_array($this->episodes) ? $this->episodes : [];
    }

    public function hasEpisodes(): bool
    {
        return ! empty($this->episodes);
    }


}