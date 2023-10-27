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
use App\Libraries\Statistics\EarningsAnalytics;
use App\Libraries\Statistics\VisitorsAnalytics;
use App\Libraries\UserAnalytics;
use App\Models\EarningsModel;
use CodeIgniter\I18n\Time;


class Statistics extends BaseController
{


  public function earnings()
  {
      $title =  lang("User/EarningsStats.earnings_stats");

      $earningsAnalytics = new EarningsAnalytics();

      $earningsSummary = $earningsAnalytics->setUserId( get_current_user_id() )
                                           ->getEarningsSummaryByType();


      $userAnalytics = new UserAnalytics( get_current_user_id() );
      $userAnalytics->initEarnings();


      $earnings =  $earningsAnalytics->setUserId( get_current_user_id() )
                                     ->getEarningsSummary();

      $data = compact('earnings','earningsSummary', 'title');
      return view( theme_path('/user/statistics/earnings'), $data );
  }

  public function referrals()
  {
      $title = lang("User/RefStats.referrals_stats");

      $visitorsAnalytics = new VisitorsAnalytics();
      $topRefByCountries = $visitorsAnalytics->setUserId( get_current_user_id() )
                                             ->getAllVisitorsByCountry( 10 );


      $data = compact('title', 'topRefByCountries');
      return view( theme_path('/user/statistics/referrals') , $data );
  }



  public function json()
  {

      $results = [];

      $chart = $this->request->getGet('chart');


      switch ($chart) {
          case 'visitors_by_month':

              $month = $this->request->getGet('month');
              $year  = $this->request->getGet('year');

              $visitorsAnalytics = new VisitorsAnalytics();
              $results = $visitorsAnalytics->setUserId( get_current_user_id() )
                                           ->json()
                                           ->getVisitsByMonth($month, $year);

              break;

          case 'visitors_by_country':

              $starDate = $this->request->getGet('start_date');
              $endDate  = $this->request->getGet('end_date');
              $isUnique = $this->request->getGet('is_unique') == 1;

              $visitorsAnalytics = new VisitorsAnalytics();
              $results = $visitorsAnalytics->setUserId( get_current_user_id() )
                                           ->json()
                                           ->getVisitsByCountry($starDate, $endDate, $isUnique);
              break;

          case 'earnings_by_month':

              $month = $this->request->getGet('month');
              $year  = $this->request->getGet('year');
              $type  = $this->request->getGet('type');

              $earningAnalytics = new EarningsAnalytics();
              $results = $earningAnalytics->setUserId( get_current_user_id() )
                                          ->setEarnType( $type )
                                          ->json()
                                          ->getEarningsByMonth($month, $year);

              break;
      }


      return $this->response->setJSON( $results );

  }

}