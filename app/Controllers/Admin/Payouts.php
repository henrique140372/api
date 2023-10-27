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
use App\Models\PayoutsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Payouts extends BaseController
{

    protected $model;

    public function __construct()
    {
        $this->model = new PayoutsModel();
    }

    public function index()
    {
        $title = 'Payouts';

        $payouts = $this->model->join('users', 'users.id = payouts.user_id', 'LEFT')
                               ->select('payouts.*, users.username')
                               ->orderBy('payouts.created_at', 'desc')
                               ->findAll();

        return view('admin/payouts/list', compact('title', 'payouts'));
    }


    public function delete( $id ): \CodeIgniter\HTTP\RedirectResponse
    {
        $payout = $this->getPayout( $id );

        if($this->model->delete( $payout->id )){

            return redirect()->back()
                             ->with('success', 'payout request successfully deleted');

        }

        return redirect()->back()
                         ->with('errors', 'something went wrong');
    }


    public function update_status( $id ): \CodeIgniter\HTTP\ResponseInterface
    {

        if(! $this->request->isAJAX()){
            throw new PageNotFoundException();
        }

        $payout = $this->getPayout( $id );
        $status = $this->request->getGet('status');

        $success = false;

        try {

            $payout->status = $status;

            if($payout->hasChanged('status')){
                $success = $this->model->save( $payout );
            }

        }catch (\Exception $e) {}

        return $this->response->setJSON(['success'=>$success]);
    }


    protected function getPayout( $id )
    {
        $payout = $this->model->where('id', $id)
                              ->first();

        if($payout === null){

            throw new PageNotFoundException();

        }

        return $payout;
    }

}
