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
use App\Entities\Payout;
use App\Models\PayoutsModel;
use App\Models\UserModel;
use CodeIgniter\Model;

class Withdrawal extends BaseController
{

    protected $model;

    public function __construct()
    {
        $this->model = new PayoutsModel();
    }

    public function index()
    {
        $title = lang("User/Earnings.my_earnings");

        $pendingPayout = $this->model->getPendingRequestByUserId( get_current_user_id() );

        $activeStars = current_user()->getActiveStars();

        $data = compact('title', 'activeStars', 'pendingPayout');
        return view(theme_path('/user/withdrawal'), $data);
    }


    public function create_redeem()
    {
        $payout = new Payout( $this->request->getPost() );
        $payout->user_id = get_current_user_id();


        // check already has pending payout requests
        if($this->model->hasPendingPayoutRequestByUserId( get_current_user_id() )){

            // no enough stars to redeem
            return redirect()->back()
                             ->with('errors', 'You can not create more than one redeem request' );

        }

        // Check user has enough stars to redeem
        if(is_numeric($payout->stars) &&
            ($payout->stars > current_user()->getActiveStars() || $payout->stars < get_config('min_payout_stars'))){

            // no enough stars to redeem
            return redirect()->back()
                             ->with('warning', 'You haven\'t enough stars to redeem' );

        }

        if($this->model->insert( $payout )) {

            return redirect()->back()
                             ->with('success', 'Your stars redeem request has successfully been scheduled');

        }

        return redirect()->back()
                         ->with('errors', 'Something went wrong');
    }

    public function cancel_redeem(): \CodeIgniter\HTTP\RedirectResponse
    {
        $pendingPayout = $this->model->getPendingRequestByUserId( get_current_user_id() );
        if($pendingPayout !== null){

            $this->model->delete( $pendingPayout->id );
            return redirect()->back()
                             ->with('warning', 'Your stars redeem request has been canceled');

        }

        return redirect()->back();
    }

}