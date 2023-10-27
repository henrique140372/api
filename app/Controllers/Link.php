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

use App\Controllers\BaseController;
use App\Models\AdsModel;
use App\Models\LinkModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Model;

class Link extends BaseController
{

    protected $model;

    public function __construct()
    {
        $this->model = new LinkModel();
    }

    public function index($id)
    {
        $link = $this->getLink( $id );

        if(! is_countdown_timer_enabled()){

            return redirect()->to( $link->link, null, 'refresh' );

        }

        //create unique token
        $bytes = random_bytes(20);
        $token = bin2hex($bytes);

        //save download token in the session
        session()->set('download_token', $token);

        //ads codes
        $adsModel = new AdsModel();
        $ads = $adsModel->forView()
                        ->getAds('link');

        $data = compact('link', 'token', 'ads');
        return view( theme_path('link'), $data);

    }


    public function get($id)
    {
        $link = $this->getLink( $id );
        $token = $this->request->getPost('token');
        $error = '';

        if($token == session()->get('download_token')){


            if(! is_dl_captcha_enabled() || $this->validate([
                'captcha' => 'required|valid_math_captcha'
            ])){

                $this->model->updateRequests($link->id);
                return redirect()->to( $link->link, null, 'refresh' );


            }else{

                $error = $this->validator->getError();

            }

        }else{

            $error = 'Invalid token';

        }

        return redirect()->back()
                         ->with('error', $error);

    }


    protected function getLink( $id )
    {
        $id = decode_id( $id );
        $link = null;

        if($id !== null){

            $link = $this->model->where('id', $id)
                ->broken(false)
                ->where('type !=', 'stream')
                ->first();

        }

        if($link === null){
            throw new PageNotFoundException('link not found');
        }

        return $link;
    }


}
