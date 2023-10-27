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



class Email extends BaseSettings
{

    public function index()
    {
        $title = 'Email Settings';

        return view('admin/settings/email', compact('title'));
    }

    public function test()
    {

        $email = new \App\Libraries\Email();

        if($email->isReady()){

            $email->base->setTo( get_config('email_address') );
            $email->base->setSubject('Email Test - VIPEmbed Script');
            $email->base->setMessage('Hi, I am working fine.');

            if($email->base->send()){
                echo "<h3>Email Send to " . get_config('email_address') . " successfully</h3>" ;
            }else{
                echo '<h3>Email Send Failed</h3>';
                echo $email->base->printDebugger(['headers']);
            }

        }else{
            echo 'Email Settings Not Ready Yet';
        }
        return;
    }


    public function update()
    {

        if ($this->request->getMethod() == 'post') {


            if($this->validate([
                'email' => 'permit_empty|valid_email'
            ])){

                $email = $this->request->getPost('email');
                $smtpSettings = $this->request->getPost('smtp');

                $data = [
                    'email_address' => $email,
                    'smtp_settings' => json_encode( $smtpSettings )
                ];

                return $this->save( $data );


            }

        }

        return redirect()->back();

    }

}