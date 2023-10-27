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

namespace App\Controllers;


use CodeIgniter\Exceptions\PageNotFoundException;

class EarnMoney extends BaseController
{

    public function index()
    {
        if(! is_users_system_enabled()){
            throw new PageNotFoundException();
        }

        $title = 'Earn Money with ' . site_name() . ' Stars';
        $customTxt = '';
        $metaKeywords = $metaDescription = '';

        helper('countries');
        $generalRewards = model('EarningsModel')->getEarnStructure();
        $referralRewards = model('RefRewardsModel')->orderBy('stars_per_view', 'desc')
                                                         ->findAll();

        $page = model('PagesModel')->getSystemPage('earn-money');
        if($page !== null){

            $title = $page->title;
            $customTxt = $page->content;

            $metaKeywords = $page->meta_keywords;
            $metaDescription = $page->meta_description;

        }

        // cache page
        $this->cacheIt('earn_money');

        $data = compact('title', 'generalRewards', 'referralRewards',
        'customTxt', 'metaKeywords', 'metaDescription');
        return view(theme_path('earn-money'), $data);
    }

}