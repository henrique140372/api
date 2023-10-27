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
use App\Libraries\Statistics\EarningsAnalytics;
use App\Libraries\Statistics\VisitorsAnalytics;
use App\Models\MovieModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\DebugTraceableTrait;
use CodeIgniter\Exceptions\PageNotFoundException;

class Statistics extends BaseController
{

    public function views()
    {
        $title = 'Videos Views Statistics';

        $movieId = $this->request->getGet('movie');
        $movie = null;

        if(! empty($movieId)){

            $movie = model('MovieModel')->getFullMovie($movieId);

            if($movie === null){
                throw new PageNotFoundException();
            }

        }

        $visitorsAnalytics = new VisitorsAnalytics();
        $topVisitsByCountries = $visitorsAnalytics->setMovieId( $movieId )
                                                  ->getAllVisitorsByCountry( 10 );

        $countOfTotalRefs = $visitorsAnalytics->setMovieId( $movieId )
                                              ->getCountOfAllVisits();

        $countOfUniqVisits = $visitorsAnalytics->setMovieId( $movieId )
                                               ->getCountOfUniqVisits();

        $data = compact('title', 'topVisitsByCountries', 'countOfTotalRefs', 'countOfUniqVisits', 'movie');
        return view('admin/statistics/visitors', $data);
    }

    public function earnings()
    {
        $title = 'Earnings Overview';

        $userId = $this->request->getGet('user');
        $user = null;

        if(! empty($userId)){

            $user = model('UserModel')->where('role !=',  UserModel::ROLE_ADMIN)
                                            ->select('id, username')
                                            ->getUser($userId);

            if($user === null){
                throw new PageNotFoundException();
            }

        }

        $earningsAnalytics = new EarningsAnalytics();
        $earningsSummary    = $earningsAnalytics->setUserId( $userId )
                                                ->getEarningsSummary();

        $earningsByType     = $earningsAnalytics->setUserId( $userId )
                                                ->getEarningsSummaryByType();

        $mostEarnedUsers    = $earningsAnalytics->getMostEarnedUsers();

        $data = compact('title', 'earningsSummary', 'earningsByType',
            'mostEarnedUsers', 'user');
        return view('admin/statistics/earnings', $data);
    }

    public function referrals()
    {
        $title = 'Videos Views by Referrals ';

        $userId = $this->request->getGet('user');
        $user = null;

        if(! empty($userId)){

            $user = model('UserModel')->where('role !=',  UserModel::ROLE_ADMIN)
                ->select('id, username')
                ->getUser($userId);

            if($user === null){
                throw new PageNotFoundException();
            }

        }

        $visitorsAnalytics = new VisitorsAnalytics();
        $topRefByCountries = $visitorsAnalytics->setUserId( $userId )
                                               ->referrals()
                                               ->getAllVisitorsByCountry( 10 );

        $topRefUsers = $visitorsAnalytics->getTopRefUsers();

        $countOfTotalRefs = $visitorsAnalytics->setUserId( $userId )
                                               ->referrals()
                                              ->getCountOfAllVisits();

        $countOfUniqVisits = $visitorsAnalytics->setUserId( $userId )
                                                ->referrals()
                                               ->getCountOfUniqVisits();


        $data = compact('title', 'topRefUsers', 'topRefByCountries',
        'countOfTotalRefs', 'countOfUniqVisits', 'user');
        return view('admin/statistics/referrals', $data);
    }

    public function json()
    {

        $results = [];

        $chart = $this->request->getGet('chart');


        switch ($chart) {
            case 'visitors_by_month':

                $month = $this->request->getGet('month');
                $year  = $this->request->getGet('year');
                $isReferrals    = $this->request->getGet('is_ref') == 1;
                $movieId = $this->request->getGet('movie');
                $userId = $this->request->getGet('user');

                $visitorsAnalytics = new VisitorsAnalytics();
                if( $isReferrals ) $visitorsAnalytics->referrals();
                if( $movieId ) $visitorsAnalytics->setMovieId( $movieId );

                $results = $visitorsAnalytics->json()
                                             ->setUserId( $userId )
                                             ->getVisitsByMonth($month, $year);

                break;

            case 'visitors_by_country':

                $starDate = $this->request->getGet('start_date');
                $endDate  = $this->request->getGet('end_date');
                $isUnique = $this->request->getGet('is_unique') == 1;
                $isReferrals  = $this->request->getGet('is_ref') == 1;
                $movieId = $this->request->getGet('movie');
                $userId = $this->request->getGet('user');

                $visitorsAnalytics = new VisitorsAnalytics();
                if( $isReferrals ) $visitorsAnalytics->referrals();
                if( $movieId ) $visitorsAnalytics->setMovieId( $movieId );

                $results = $visitorsAnalytics->json()
                                             ->setUserId( $userId )
                                             ->getVisitsByCountry($starDate, $endDate, $isUnique);
                break;

            case 'earnings_by_month':

                $month = $this->request->getGet('month');
                $year  = $this->request->getGet('year');
                $type  = $this->request->getGet('type');
                $userId = $this->request->getGet('user');

                $earningAnalytics = new EarningsAnalytics();

                $results = $earningAnalytics->setEarnType( $type )
                                            ->setUserId( $userId )
                                            ->json()
                                            ->getEarningsByMonth($month, $year);

                break;
        }


        return $this->response->setJSON( $results );

    }

}
