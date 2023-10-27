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
use App\Models\PayoutsModel;

class Payouts extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PayoutsModel();
    }

    public function index()
    {
        $title =  lang("User/Payouts.payouts");

        $payouts = $this->model->_completed()
                               ->orderBy('id', 'DESC')
                               ->getPayoutRequestsByUserId( get_current_user_id() );




        $data = compact('title', 'payouts');
        return view(theme_path('/user/payouts'), $data);
    }

}