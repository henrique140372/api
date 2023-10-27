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

namespace App\Libraries\Statistics;

use App\Models\EarningsModel;
use App\Models\PayoutsModel;
use App\Models\UserModel;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\I18n\Time;

/**
 * Class EarningsAnalytics
 * @package App\Libraries\Statistics
 */
class EarningsAnalytics
{

    /**
     * Database
     * @var BaseBuilder
     */
    protected $db;

    /**
     * Current datetime
     * @var bool|string
     */
    protected $timenow;

    /**
     * Target month
     * @var int
     */
    protected $month;

    /**
     * Target year
     * @var int
     */
    protected $year;

    /**
     * Target user id
     * @var int
     */
    protected $userId;

    /**
     * Earnings type
     * @var null|string
     */
    protected $earnType;

    /**
     * Results return type
     * @var string array|json
     */
    protected $returnType = 'array';

    /**
     * Loaded analytics data
     * @var array
     */
    protected $data = [];

    /**
     * VisitorsAnalytics constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $this->db = \Config\Database::connect()->table('earnings');

        $timeNow = Time::now();
        $this->timenow = $timeNow->toDateTimeString();
        $this->month = sprintf("%02d", $timeNow->getMonth());
        $this->year = $timeNow->getYear();

    }

    public function setUserId( $userId )
    {
        if(is_numeric($userId) && $userId > 0){
            $this->userId = $userId;
        }
        return $this;
    }

    public function setEarnType( $type )
    {
        $this->earnType = $type;
        return $this;
    }

    public function json()
    {
        $this->returnType = 'json';
        return $this;
    }

    public function array()
    {
        $this->returnType = 'array';
        return $this;
    }

    public function getEarningsSummaryByType(): array
    {
        $data = [];
        foreach (EarningsModel::getEarningsTypes() as $type) {
            $data[$type] = [
                'credited' => 0,
                'pending'  => 0,
                'rejected' => 0
            ];
        }

        $status = [
            'credited' => EarningsModel::STATUS_CREDITED,
            'pending' => EarningsModel::STATUS_PENDING,
            'rejected' => EarningsModel::STATUS_REJECTED
        ];

        foreach ($status as $k => $st) {
            $this->filterGeneralData();
            $stars = $this->db->where('status', $st)
                                ->select('type, stars')
                                ->selectSum('stars')
                                ->groupBy('type')
                                ->get()
                                ->getResultArray();

            if(! empty($stars)){

                foreach ($stars as $star) {

                    $type = $star['type'];
                    if(isset($data[$type][$k])){
                        $data[$type][$k] = $star['stars'];
                    }

                }

            }
        }

        return $data;
    }

    public function getMostEarnedUsers(int $limit = 10): array
    {
        return $this->db->join('users', 'earnings.user_id = users.id', 'LEFT')
                        ->where('earnings.status', EarningsModel::STATUS_CREDITED)
                        ->where('users.status', UserModel::STATUS_ACTIVE)
                        ->select('SUM(earnings.stars) as stars,earnings.user_id , users.username')
                        ->groupBy('user_id')
                        ->orderBy('stars', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->getResultArray();
    }

    public function getEarningsSummary(): array
    {
        // get credited stars
        $this->filterGeneralData();
        $credited = (int) $this->db->where('status', EarningsModel::STATUS_CREDITED)
                                   ->selectSum('stars')
                                   ->get()
                                   ->getFirstRow()
                                   ->stars;

        // get pending stars
        $this->filterGeneralData();
        $pending = (int) $this->db->where('status', EarningsModel::STATUS_PENDING)
                                  ->selectSum('stars')
                                  ->get()
                                  ->getFirstRow()
                                  ->stars;

        // get active stars
        $payoutsModel = new PayoutsModel();
        if(! empty($this->userId)){
            $payoutsModel->_user( $this->userId );
        }
        $redeemed = (int) model('PayoutsModel')->_completed()
                                                   ->selectSum('stars')
                                                   ->first()
                                                   ->stars;

        $active = 0;
        if($credited > $redeemed){
            $active = $credited - $redeemed;
        }

        return compact('credited', 'pending', 'redeemed', 'active');
    }

    public function getEarningsByMonth($month = null, $year = null)
    {
        if(is_numeric($year) && ( $year > 2021 && $year < 2100 )){
            $this->year = $year;
        }

        if(is_numeric($month) && $month > 0){
            $this->month = sprintf("%02d", $month);
        }

        $filterDate = "{$this->year}-{$this->month}";


        $this->filterGeneralData();
        $data =  $this->db->where('DATE_FORMAT(created_at, "%Y-%m")', $filterDate)
                         ->select('DATE(created_at) as date, sum(stars) as stars')
                         ->groupBy('DAY(created_at)')
                         ->get()
                         ->getResultArray();

        $data = $this->formatMonthlyData( $data );
        return $this->returnType == 'json' ? json_encode($data) : $data;
    }

    protected function filterGeneralData()
    {
        // Filter by user id
        if(! empty($this->userId)){
            $this->db->where('user_id', $this->userId);
        }

        // Filter by earn type
        if(! empty($this->earnType)){
            $this->db->where('type', $this->earnType);
        }
    }

    protected function formatMonthlyData(?array $data): array
    {
        $results = [];
        if(! empty($data)){

            $lastDay = date("t", strtotime($data[0]['date']));
            $tmpData = [
                'date' => '',
                'stars' => 0
            ];
            //init temporary data
            for($i = 1; $i <=  $lastDay; $i++)
            {
                $day = str_pad($i, 2, '0', STR_PAD_LEFT);
                $tmpData['date'] = $this->year . "-" . $this->month . "-" . $day;
                $results[$day] = $tmpData;
            }

            foreach ($data as $val){

                $cDay = date("d", strtotime($val['date']));

                if(array_key_exists($cDay, $results)){
                    $results[$cDay]['stars'] = $val['stars'];
                }

            }

        }

        return $results;
    }


}