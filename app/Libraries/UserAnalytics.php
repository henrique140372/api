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

namespace App\Libraries;


use App\Models\EarningsModel;
use App\Models\LinkModel;

class UserAnalytics {

    protected $db;

    protected $userId;
    protected $data;

    public function __construct(int $userId)
    {
        $this->db = \Config\Database::connect();
        $this->initDataMap();
        $this->userId = $userId;
    }

    public function init(): UserAnalytics
    {
        $this->initEarnings();
        $this->CalcReliability();

        return $this;

    }

    public function getData($asArray = false)
    {
        $data = $this->data;
        if(! $asArray)
            $data = json_decode( json_encode( $data ) );

        return $data;
    }

    public function initEarnings()
    {
        $builder = $this->db->table('earnings');

        // get credited stars
        $credited = $builder->where('user_id', $this->userId)
                           ->where('status', EarningsModel::STATUS_CREDITED)
                           ->selectSum('stars')
                           ->get()
                           ->getFirstRow()
                           ->stars;

        // get pending stars
        $pending = $builder->where('user_id', $this->userId)
                           ->where('status', EarningsModel::STATUS_PENDING)
                           ->selectSum('stars')
                           ->get()
                           ->getFirstRow()
                           ->stars;


        $this->setVal('earnings',
            compact('credited', 'pending'));

    }

    protected function CalcReliability()
    {
        $builder = $this->db->table('links');
        $reliability = 0;

        // get total links
        $totalLinks = $builder->where('user_id', $this->userId)
                              ->where('status !=', LinkModel::STATUS_PENDING)
                              ->countAllResults();

        // get active links
        $activeLinks = $builder->where('user_id', $this->userId)
                               ->where('status', LinkModel::STATUS_APPROVED)
                               ->countAllResults();

        if(! empty($totalLinks) && $totalLinks >= $activeLinks){
            $reliability = floor( $activeLinks / $totalLinks * 100 );
        }


        $this->setVal('reliability', $reliability);
    }

    protected function initDataMap()
    {
        $dataMap = [
            'earnings' => [
                'credited' => 0,
                'pending' => 0
            ],
            'reliability' => 0
        ];

        $this->data = $dataMap;

    }


    protected function setVal($key , $data)
    {
        if(isset( $this->data[$key] )){
            $this->data[$key] = $data;
        }
    }



}