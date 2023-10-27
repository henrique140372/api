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
use App\Models\EarningsModel;
use App\Models\MovieModel;

class StarsLog extends BaseController
{


    public function index()
    {
        $title =  lang("User/StarsLog.stars_log");

        $status = $this->request->getGet('status');
        if(! in_array($status, [
            EarningsModel::STATUS_CREDITED,
            EarningsModel::STATUS_PENDING,
            EarningsModel::STATUS_REJECTED
        ])){
            $status = 'all';
        }

        $earningsModel = new EarningsModel();
        if($status !== 'all'){
            $earningsModel->where('status', $status);
        }
        $earnings = $earningsModel->_user( get_current_user_id() )
                                  ->where('type !=', EarningsModel::TYPE_REF_EARN)

                                  ->orderBy('created_at', 'desc')
                                  ->findAll();

        if($status !== 'all'){
            $earningsModel->where('status', $status);
        }
        $refEarnings = $earningsModel->_user( get_current_user_id() )
                                     ->where('type', EarningsModel::TYPE_REF_EARN)
                                     ->first();
        if(! empty($refEarnings)){
            array_unshift($earnings, $refEarnings);
        }

        $data =  compact('title', 'earnings', 'status');
        return view(theme_path('/user/stars-log'), $data);
    }


}