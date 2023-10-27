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

namespace App\Controllers\Admin\Settings;



class Users extends BaseSettings
{

    public function index()
    {
        $title = 'Users Settings';

        return view('admin/settings/users', compact('title'));
    }


    public function update()
    {

        if ($this->request->getMethod() == 'post') {

            $data = [];

            $starsExchange = $this->request->getPost('stars_exchange_rate');
            $data['stars_exchange_rate'] = is_numeric( $starsExchange )  ? $starsExchange : 0;

            $minStarsPayout = $this->request->getPost('min_payout_stars');
            $data['min_payout_stars'] = is_numeric( $minStarsPayout ) && $minStarsPayout > 0  ? $minStarsPayout : 0;

            $paymentMethods = $this->request->getPost('payment_methods_for_payouts');
            $paymentMethods = ! empty( $paymentMethods ) ? explode(',', str_replace(' ', '', $paymentMethods)) : [];
            $data['payment_methods_for_payouts'] = json_encode($paymentMethods);

            $data['note_about_payout_date'] = $this->request->getPost('note_about_payout_date');
            $data['max_steaming_links_per_user'] = $this->request->getPost('max_steaming_links_per_user');
            $data['max_download_links_per_user'] = $this->request->getPost('max_download_links_per_user');
            $data['max_torrent_links_per_user'] = $this->request->getPost('max_torrent_links_per_user');

            $data['users_system'] =  $this->request->getPost('users_system') == 1;
            $data['ref_rewards_system'] =  $this->request->getPost('ref_rewards_system') == 1;
            $data['user_email_verification'] =  $this->request->getPost('user_email_verification') == 1;
            $data['user_admin_approval'] =  $this->request->getPost('user_admin_approval') == 1;
            $data['is_2fa_login'] =  $this->request->getPost('is_2fa_login') == 1;

            return $this->save( $data );

        }

        return redirect()->back();

    }

}