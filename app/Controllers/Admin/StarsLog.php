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
use App\Models\EarningsModel;
use App\Models\RequestsModel;
use App\Models\RequestSubscriptionModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\DebugTraceableTrait;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Model;


class StarsLog extends BaseController
{

    public function index()
    {
        $title = 'Stars Log';

        $user = $this->getUser();

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
        $earnings = $earningsModel->_user( $user->id )
            ->where('type !=', EarningsModel::TYPE_REF_EARN)

            ->orderBy('created_at', 'desc')
            ->findAll();

        if($status !== 'all'){
            $earningsModel->where('status', $status);
        }
        $refEarnings = $earningsModel->_user( $user->id )
            ->where('type', EarningsModel::TYPE_REF_EARN)
            ->first();
        if(! empty($refEarnings)){
            array_unshift($earnings, $refEarnings);
        }

        $data =  compact('title', 'earnings', 'status', 'user');
        return view('/admin/stars_log/index', $data);
    }



    protected function getUser()
    {
        $userId = $this->request->getGet('user');
        $user = null;

        if(! empty($userId)){

            $user = model('UserModel')->where('role !=',  UserModel::ROLE_ADMIN)
                ->select('id, username')
                ->getUser($userId);


        }

        if($user === null){
            throw new PageNotFoundException();
        }

        return $user;
    }






}
