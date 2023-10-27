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
use App\Models\PayoutsModel;
use CodeIgniter\I18n\Time;

class Analytics {

    protected $db;
    protected $date;
    protected $data;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->date = Time::now()->toDateString();
        $this->initDataMap();
    }

    public function init(): Analytics
    {
        $this->initMovies();
        $this->initSeries();
        $this->initEpisodes();
        $this->initLinks();
        $this->initLinksRequests();
        $this->initReportedLinks();
        $this->initLinksCompletion();
        $this->initViews();
        $this->initUsersLinks();
        $this->initUsersAccBalance();
        $this->initPayouts();
        $this->initMoviesRequests();
        $this->initUsers();
        $this->calcCoverage();

        return $this;

    }

    protected function todayData( $builder )
    {
         $builder->where('DATE_FORMAT(created_at, "%Y-%m-%d")', $this->date);
         return $builder;
    }

    public function initUsers()
    {
        $builder = $this->db->table('users');

        //total users
        $total = $builder->countAll() - 1;

        // get users who is registered in current day
        $today =  $this->todayData( $builder)
                       ->countAllResults();

        $this->setVal('users', compact('total', 'today'));
    }

    public function initNextForYou()
    {
        $builder = $this->db->table('failed_movies');

        $pending = $builder->countAll();

        $this->setVal('next_for_you', compact('pending'));
    }

    public function initMoviesRequests()
    {
        $builder = $this->db->table('requests');

        $pending = $builder->where('status', 'pending')
                           ->countAllResults();

        $this->setVal('movies_requests', compact('pending'));
    }

    public function initPayouts()
    {
        $builder = $this->db->table('payouts');

        $pending = $builder->where('status', PayoutsModel::STATUS_PENDING)
                         ->countAllResults();


        $this->setVal('payouts', compact('pending'));
    }

    public function initUsersAccBalance()
    {
        $builder = $this->db->table('earnings');

        //get earned stars
        $earnedStars = (int) $builder->where('status', EarningsModel::STATUS_CREDITED)
                                     ->selectSum('stars')
                                     ->get()
                                     ->getRow()
                                      ->stars;


        // get redeem stars
        $builder = $this->db->table('payouts');
        $redeem = (int) $builder->where('status', PayoutsModel::STATUS_COMPLETED)
                                ->selectSum('stars')
                                ->get()
                                ->getRow()
                                ->stars;

        $balance = 0;
        if($earnedStars > $redeem){
            $balance = stars_exchange( $earnedStars - $redeem );
        }

        $this->setVal('users_balance', $balance);
    }

    public function initUsersLinks()
    {
        $builder = $this->db->table('links');

        // approved links
        $approved = $builder->where('status', LinkModel::STATUS_APPROVED)
                            ->where('user_id !=', '1')
                            ->countAllResults();
        // pending links
        $pending = $builder->where('status', LinkModel::STATUS_PENDING)
                            ->where('user_id !=', '1')
                            ->countAllResults();

        // pending links
        $rejected = $builder->where('status', LinkModel::STATUS_REJECTED)
                            ->where('user_id !=', '1')
                            ->countAllResults();

        // total links
        $total = $approved + $pending + $rejected;

        $this->setVal('users_links', compact('total', 'approved', 'pending', 'rejected'));
    }

    public function initViews()
    {
        $builder = $this->db->table('visitors');

        //get total views for movies
        $totalMovies = $builder->join('movies', 'movies.id = visitors.movie_id', 'LEFT')
                         ->where('movies.type', 'movie')
                         ->selectSum('visitors.views')
                         ->get()
                         ->getFirstRow()
                         ->views;

        //get unique views for movies
        $uniqMovies = $builder->join('movies', 'movies.id = visitors.movie_id', 'LEFT')
                              ->where('movies.type', 'movie')
                              ->countAllResults();

        //get total views for episode
        $totalEpisodes = $builder->join('movies', 'movies.id = visitors.movie_id', 'LEFT')
                                 ->where('movies.type', 'episode')
                                 ->selectSum('visitors.views')
                                 ->get()
                                 ->getFirstRow()
                                 ->views;

        //get unique views for episode
        $uniqEpisodes = $builder->join('movies', 'movies.id = visitors.movie_id', 'LEFT')
                                 ->where('movies.type', 'episode')
                                 ->countAllResults();

        //get total referrals for movies
        $totalMoviesRef = $builder->join('movies', 'movies.id = visitors.movie_id', 'LEFT')
                            ->where('movies.type', 'movie')
                            ->where('visitors.ref_user_id !=', '')
                            ->selectSum('visitors.views')
                            ->get()
                            ->getFirstRow()
                            ->views;

        //get unique referrals for movies
        $uniqMoviesRef = $builder->join('movies', 'movies.id = visitors.movie_id', 'LEFT')
                                 ->where('movies.type', 'movie')
                                 ->where('visitors.ref_user_id !=', '')
                                 ->countAllResults();

        //get total referrals for movies
        $totalEpisodesRef = $builder->join('movies', 'movies.id = visitors.movie_id', 'LEFT')
                                 ->where('movies.type', 'episode')
                                 ->where('visitors.ref_user_id !=', '')
                                 ->selectSum('visitors.views')
                                 ->get()
                                 ->getFirstRow()
                                 ->views;

        //get unique referrals for movies
        $uniqEpisodesRef = $builder->join('movies', 'movies.id = visitors.movie_id', 'LEFT')
            ->where('movies.type', 'episode')
            ->where('visitors.ref_user_id !=', '')
            ->countAllResults();

        $data = [
            'movies' => [
                'total'         => (int) $totalMovies,
                'unique'        => (int) $uniqMovies,
                'ref_total'     => (int) $totalMoviesRef,
                'ref_unique'    => (int) $uniqMoviesRef
            ],
            'episodes' => [
                'total'         => (int) $totalEpisodes,
                'unique'        => (int) $uniqEpisodes,
                'ref_total'     => (int) $totalEpisodesRef,
                'ref_unique'    => (int) $uniqEpisodesRef
            ]
        ];

        $this->setVal('views', $data);
    }

    public function getData($asArray = false)
    {
        $data = $this->data;
        if(! $asArray)
            $data = json_decode( json_encode( $data ) );

        return $data;
    }

    protected function initMovies()
    {
        $builder = $this->db->table('movies');

        //get total movies
        $total = $builder->where('type', 'movie')
                         ->countAllResults();

        //get today added movies
        $today = $this->todayData( $builder )->where('type', 'movie')
                                             ->countAllResults();

        //movies with links
        $with_links = $builder->join('links', 'links.movie_id = movies.id')
                              ->select('movies.id')
                              ->where('movies.type', 'movie')
                              ->where('links.type', 'stream')
                              ->groupBy('movies.id')
                              ->countAllResults();

        $without_links = $total - $with_links;
        $links_completion_rate = $total > 0 ? round( $with_links / $total * 100 ) : 0;


        $data = compact('total', 'today', 'with_links', 'without_links',
            'links_completion_rate');
        $this->setVal('movies', $data);

    }

    protected function initSeries()
    {
        $builder = $this->db->table('series');

        //get total series
        $total = $builder->countAllResults();

        //get today added series
        $today = $this->todayData( $builder )
                      ->countAllResults();

        //completed series
        $completed = $builder->where('is_completed', 1)
                             ->countAllResults();

        $incomplete = $total - $completed;

        //completion rate
        $completion_rate = $total > 0 ? round( $completed / $total * 100 ) : 0;

        $data = compact('total','today', 'completed', 'incomplete', 'completion_rate');
        $this->setVal('series', $data);

    }

    protected function initEpisodes()
    {
        $builder = $this->db->table('movies');

        //total episodes
        $total = $this->db->table('seasons')
                                  ->selectSum('total_episodes')
                                  ->get()
                                  ->getFirstRow()
                                  ->total_episodes;


        //completed episodes
        $completed = $builder->where('type', 'episode')
                             ->countAllResults();

        //today added
        $today = $this->todayData( $builder )
                      ->where('type', 'episode')
                      ->countAllResults();

        $incomplete = $total - $completed;
        if($incomplete < 0) $incomplete = 0;

        //completion rate
        $completion_rate = $total > 0 ? round( $completed / $total * 100 ) : 0;

        //episodes with links
        $with_links = $builder->join('links', 'links.movie_id = movies.id')
                              ->select('movies.id')
                              ->where('movies.type', 'episode')
                              ->where('links.type', 'stream')
                              ->groupBy('movies.id')
                              ->countAllResults();

        $without_links = $completed - $with_links;
        $links_completion_rate = $total > 0 ? round( $with_links / $total * 100 ) : 0;


        $data = compact('total','today', 'completed', 'incomplete', 'with_links',
            'without_links', 'links_completion_rate', 'completion_rate');

        $this->setVal('episodes', $data);

    }

    protected function initLinks()
    {
        $builder = $this->db->table('links');

        //total links
        $total = $builder->countAllResults();

        //streaming links
        $stream =  $builder->where('type', LinkModel::TYPE_STREAM)
                           ->countAllResults();

        //direct download links
        $direct_dl =  $builder->where('type', LinkModel::TYPE_DIRECT_DL)
                              ->countAllResults();

        //torrent download links
        $torrent_dl = $total - ( $stream + $direct_dl );

        $data = compact('total', 'stream', 'direct_dl', 'torrent_dl');

        $this->setVal('links', $data);

    }

    protected function initLinksRequests()
    {
        //total links requests
        $total = $this->__countLinksRequests();

        //stream links requests
        $stream = $this->__countLinksRequests(LinkModel::TYPE_STREAM);

        //direct links requests
        $direct_dl = $this->__countLinksRequests(LinkModel::TYPE_DIRECT_DL);

        //torrent links requests
        $torrent_dl = $total - ( $stream + $direct_dl );

        $data = compact('total', 'stream', 'direct_dl', 'torrent_dl');
        $this->setVal('links_requests', $data);

    }

    protected function initReportedLinks()
    {
        //total reported links
        $total = $this->__countReportedLinks();

        //reported stream links
        $stream = $this->__countReportedLinks(LinkModel::TYPE_STREAM);

        //reported direct download links
        $direct_dl = $this->__countReportedLinks(LinkModel::TYPE_DIRECT_DL);

        //reported torrent download links
        $torrent_dl = $total - ( $stream + $direct_dl  );

        $data = compact('total', 'stream', 'direct_dl', 'torrent_dl');
        $this->setVal('reported_links', $data);

    }

    protected function initLinksCompletion()
    {
        $builder = $this->db->table('movies');

        //get total movies
        $total = $builder->countAllResults();

        //streaming links completion
        $with = $builder->join('links', 'links.movie_id = movies.id')
                        ->select('movies.id')
                        ->where('links.type', 'stream')
                        ->groupBy('movies.id')
                        ->countAllResults();

        $without = $total - $with;
        $completion_rate = 0;
        if($total > 0){
            $completion_rate = $total > 0 ? floor( $with / $total * 100 ) : 0;
        }

        $data['stream'] = compact('with', 'without', 'completion_rate');


        //download links completion
        $with = $builder->join('links', 'links.movie_id = movies.id')
                        ->select('movies.id')
                        ->where('links.type !=', 'stream')
                        ->groupBy('movies.id')
                        ->countAllResults();

        $without = $total - $with;
        $completion_rate = 0;
        if($total > 0){
            $completion_rate = $total > 0 ? floor( $with / $total * 100 ) : 0;
        }

        $data['download'] = compact('with', 'without', 'completion_rate');

        $this->setVal('links_completion', $data);

    }

    protected function calcCoverage()
    {
        //get total movies
        $total = $this->db->table('movies')
                          ->countAllResults();

        //get failed movies
        $failed = $this->db->table('failed_movies')
                           ->countAllResults();

        $value = $total > 0 ? floor( $total / ( $total + $failed ) * 100 ) : 0;

        switch ($value) {
            case $value >= 75:
                $color_class = 'green';
                break;
            case $value >= 50:
                $color_class = 'yellow';
                break;
            case $value > 0:
                $color_class = 'red';
                break;
            default:
                $color_class = 'light-grey';
        }

        $this->setVal('coverage', compact('value', 'color_class'));

    }

    protected function __countLinksRequests(?string $type = '')
    {
        $builder = $this->db->table('links');

        if(! empty( $type ))
            $builder->where('type', $type);

        $requests = $builder->selectSum('requests')
                            ->get()
                            ->getFirstRow()
                            ->requests;

        return is_numeric( $requests ) ? $requests : 0;
    }

    protected function __countReportedLinks(?string $type = '')
    {
        $builder = $this->db->table('links');

        if(! empty( $type ))
            $builder->where('type', $type);

        return $builder->groupStart()
                            ->where('reports_not_working >', 0)
                            ->orWhere('reports_wrong_link >', 0)
                        ->groupEnd()
                       ->countAllResults();
    }

    protected function initDataMap()
    {
        $dataMap = [
            'coverage' => [
                'value' => 0,
                'color_class' => ''
            ],
            'movies' => [
                'total' => 0,
                'today' => 0,
                'views' => 0
            ],
            'series' => [
                'total' => 0,
                'today' => 0,
                'completion_rate' => 0,
                'completed' => 0,
                'incomplete' => 0
            ],
            'episodes' => [
                'total' => 0,
                'today' => 0,
                'completion_rate' => 0,
                'completed' => 0,
                'incomplete' => 0,
                'views' => 0
            ],
            'links' => [
                'total' => 0,
                'stream' => 0,
                'direct_dl' => 0,
                'torrent_dl' => 0
            ],
            'links_requests' => [
                'total' => 0,
                'stream' => 0,
                'direct_dl' => 0,
                'torrent_dl' => 0
            ],
            'reported_links' => [
                'total' => 0,
                'stream' => 0,
                'direct_dl' => 0,
                'torrent_dl' => 0
            ],
            'links_completion' => [
                'stream' => [
                    'with' => 0,
                    'without' => 0,
                    'completion_rate' => 0
                ],
                'download' => [
                    'with' => 0,
                    'without' => 0,
                    'completion_rate' => 0
                ]
            ],
            'views' => [
                'movies' => [
                    'total' => 0,
                    'unique' => 0,
                    'ref_total' => 0,
                    'ref_unique' => 0
                ],
                'episodes' => [
                    'total' => 0,
                    'unique' => 0,
                    'ref_total' => 0,
                    'ref_unique' => 0
                ],
            ],
            'users_links' => [
                'total' => 0,
                'approved' => 0,
                'pending'  => 0,
                'rejected' => 0
            ],
            'users' => [
                'total' => 0,
                'today' => 0
            ],
            'payouts' => [
                'pending' => 0
            ],
            'movies_requests' => [
                'pending' => 0
            ],
            'next_for_you' => [
                'pending' => 0
            ],
            'users_balance' => 0
        ];

        $this->data = $dataMap;

    }

    protected function setVal($key , $data)
    {
        if(isset( $this->data[$key] )){
            $this->data[$key] = $data;
        }
    }

    public function getVisitorsData(?int $month, ?int $year, ?int $movieId )
    {
        $results = [];
    }


}