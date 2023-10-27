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

namespace App\Libraries;

use CodeIgniter\I18n\Time;

class MailSender extends Email
{


    public function sendWelcomeMessage(\App\Entities\User $user)
    {
        // Check email class is ready to use
        if(! $this->isReady()){
            return null;
        }

        $data = [
            'username'   => $user->username,
            'login_link' => site_url('/login')
        ];

        // Attempt to load mail template
        if($this->setTemplate('welcome')
                ->setData( $data )
                ->load()){

            $subject = 'Welcome to ' . site_name();
            $this->base->setTo( $user->email )
                       ->setSubject( $subject )
                       ->send();

        }

    }

    public function sendEmailVerificationLink(\App\Entities\User $user, $verificationLink = null)
    {
        if(! $this->isReady()){
            return null;
        }

        $data = [
            'username' => $user->username,
            'verification_link' => $verificationLink
        ];

        if($this->setTemplate('confirm_email')
                ->setData( $data )
                ->load()){

            $subject = 'Please Confirm Your Email Address';
            $this->base->setTo( $user->email )
                       ->setSubject( $subject )
                       ->send();

        }
    }


    public function sendPsswdResetVerificationLink(\App\Entities\User $user, $verificationLink = null)
    {
        if(! $this->isReady()){
            return null;
        }

        $data = [
            'username' => $user->username,
            'verification_link' => $verificationLink
        ];

        if($this->setTemplate('reset_password')
            ->setData( $data )
            ->load()){

            $subject = 'Your Password Reset Request';
            $this->base->setTo( $user->email )
                       ->setSubject( $subject )
                       ->send();

        }
    }

    public function send2FaAuthenticationCode(\App\Entities\User $user, $code = null)
    {
        if(! $this->isReady()){
            return null;
        }

        $visitorInfo = new VisitorInfo\VisitorInfo();

        $data = [
            'username' => $user->username,
            'code' => $code,
            'user_device' => $visitorInfo->getUserAgent(),
            'user_ip' => $visitorInfo->getIp()
        ];

        if($this->setTemplate('2fa_verify')
                ->setData( $data )
                ->load()){

            $subject = 'Your confirmation code';
            $this->base->setTo( $user->email )
                       ->setSubject( $subject )
                       ->send();

        }
    }


    public function sendMessageToAdmin($name, $email, $msg)
    {
        if(! $this->isReady()){
            return null;
        }

        $adminInfo = get_admin_user_info();
        if(empty($adminInfo)){
            return null;
        }

        $adminEmail = ! empty($adminInfo->email) ? $adminInfo->email : '';
        if(empty( $adminEmail )){
            return null;
        }

        $adminUserName = $adminInfo->username;

        $data = [
            'USERNAME'          => esc( $adminUserName ),
            'SENDER_NAME'       =>  esc( $name ),
            'SENDER_EMAIL'      =>  esc( $email ),
            'SENDER_MESSAGE'    =>  esc( $msg ),
            'SEND_DATE'         =>  Time::now()->toDateTimeString()
        ];

        if($this->setTemplate('new_message')
                ->setData( $data )
                ->load()){

            $subject = 'New message from ' . esc( $name );
            if($this->base->setTo( $adminEmail )
                          ->setSubject( $subject )
                          ->send()){

                return true;
            }

        }

        return false;
    }


}