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
use App\Models\UserModel;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\I18n\Time;

/**
 * Class VisitorsAnalytics
 */
class VisitorsAnalytics
{

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
     * Target movie id
     * @var int
     */
    protected $movieId;

    /**
     * Target user id
     * @var int
     */
    protected $userId;

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
        $this->db = \Config\Database::connect()->table('visitors');

        $timeNow = Time::now();
        $this->timenow = $timeNow->toDateTimeString();
        $this->month = sprintf("%02d", $timeNow->getMonth());
        $this->year = $timeNow->getYear();

    }

    public function setMovieId( $movieId )
    {
        if(is_numeric($movieId) && $movieId > 0){
            $this->movieId = $movieId;
        }
        return $this;
    }

    public function setUserId( $userId )
    {
        if(is_numeric($userId) && $userId > 0){
            $this->userId = $userId;
        }
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

    public function getVisitsByCountry($startDate = null, $endDate = null, $isUniq = false)
    {
        $data = [];

        //The order in which the results should be processed
        $orderBy = ! $isUniq ? 'totalVisits' : 'uniqVisits';

        // Filter by datetime
        if(! empty($startDate) && ! empty($endDate)){

            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));

            if($startDate !== $endDate){
                $this->db->where("DATE_FORMAT(created_at, \"%Y-%m-%d\") BETWEEN '" . $startDate . "' AND '" . $endDate . "'", null, false);
            }else{
                $this->db->where('DATE_FORMAT(created_at, "%Y-%m-%d")', $startDate);
            }

        }else{

            $this->db->where('DATE_FORMAT(created_at, "%Y-%m")', date('Y-m', strtotime($this->timenow)));

        }


        $this->filterGeneralData();

        $results = $this->db->where('country_code !=', '')
                            ->select('country_code,  sum(views) as totalVisits, count(id) as uniqVisits')
                            ->orderBy( $orderBy, 'DESC' )
                            ->groupBy('country_code')
                            ->get()
                            ->getResultArray();

        if(!empty($results)){

            foreach ($results as $val){

                $visits = ! $isUniq ? $val['totalVisits'] : $val['uniqVisits'];
                $cc = strtolower($val['country_code']);
                $data[$cc] = $visits;

            }

        }

        return $this->returnType == 'json' ? json_encode($data) : $data;
    }

    public function getVisitsByMonth($month = null, $year = null)
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
                         ->select('DATE(created_at) as date, sum(views) as totalVisits, count(id) as uniqVisits')
                         ->groupBy('DAY(created_at)')
                         ->get()
                         ->getResultArray();

        $data = $this->formatMonthlyData( $data );
        return $this->returnType == 'json' ? json_encode($data) : $data;
    }

    public function getAllVisitorsByCountry(int $limit = 0)
    {
        helper('countries');
        $this->filterGeneralData();
        $results = $this->db->where('country_code !=', '')
                            ->select('country_code,  sum(views) as totalVisits, count(id) as uniqVisits')
                            ->orderBy( 'sum(views)', 'DESC' )
                            ->groupBy('country_code')
                            ->limit( $limit )
                            ->get()
                            ->getResultArray();


        if(!empty($results)){

            foreach ($results as $key => $val){

                $countryName = get_country_by_code($val['country_code']);
                $results[$key]['country_name'] = $countryName;

            }

        }

        return $results;

    }

    public function referrals()
    {
        $this->db->where('ref_user_id != ', '');
        return $this;
    }

    public function getCountOfAllVisits(): int
    {
        $this->filterGeneralData();
        return (int) $this->db->selectSum('views')
                              ->get()
                              ->getFirstRow()
                              ->views;
    }

    public function getCountOfUniqVisits(): int
    {
        $this->filterGeneralData();
        return (int) $this->db->selectCount('views')
                              ->get()
                              ->getFirstRow()
                              ->views;
    }

    public function getTopRefUsers(int $limit = 10): array
    {
        return $this->db->join('users', 'visitors.ref_user_id = users.id', 'RIGHT')
                        ->select('COUNT(visitors.id) as referrals,
                                        visitors.ref_user_id as user_id, users.username')
                        ->groupBy('visitors.ref_user_id')
                        ->orderBy('referrals', 'DESC')
                        ->where('visitors.ref_user_id !=', '')
                        ->limit( $limit )
                        ->get()
                        ->getResultArray();
    }


    protected function filterGeneralData()
    {
        // Filter by user id
        if(! empty($this->userId)){
            $this->db->where('ref_user_id', $this->userId);
        }

        // Filter by movie id
        if(! empty($this->movieId)){
            $this->db->where('movie_id', $this->movieId);
        }
    }

    protected function formatMonthlyData(?array $data): array
    {
        $results = [];
        if(! empty($data)){

            $lastDay = date("t", strtotime($data[0]['date']));
            $tmpData = [
                'date' => '',
                'visits' => 0,
                'uniqVisits' => 0
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
                    $results[$cDay]['visits'] = $val['totalVisits'];
                    $results[$cDay]['uniqVisits'] = $val['uniqVisits'];
                }

            }


        }

        return $results;
    }


}