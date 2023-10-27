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

use App\Entities\User;
use App\Libraries\UniqToken;
use App\Libraries\Verification\EmailVerification;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;


class Register extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        $title = lang("Register.page_title");

        return view(theme_path('/register/register'), compact('title'));
    }


    public function confirm()
    {
        $title = 'Verify your email';

        // Get current user by token
        $user = $this->getUserByToken();
        $emailVerification = new EmailVerification( $user );

        // Check account is already activated
        if($user->isEmailVerified() || $user->isActive()){

            // Check still admin approval is pending
            if($user->isPending() && is_user_admin_approval_enabled() && ! $user->isAdminApproved()){

                // redirect to admin approval msg page
                return redirect()->to('/register/wait?token=' . $user->getToken());

            }

            //redirect to home
            return redirect()->to('/home');
        }


        if($this->request->getGet('resent_mail') == 1){

            if(! $emailVerification->isMaxSendMails()){

                $emailVerification->sendMail();

                return redirect()->back()
                                 ->with('success', 'We resent the email. Please check your inbox');

            }

            return redirect()->back()
                             ->with('errors', 'We\'re unable to resend the email');
        }

        $isMaxSendMails = $emailVerification->isMaxSendMails();
        $data = compact('title', 'user', 'isMaxSendMails');
        return view(theme_path('/register/confirm'), $data);
    }

    public function create()
    {
        if($this->request->getMethod() != 'post'){
            throw new PageNotFoundException('Invalid request');
        }

        // G Captcha validation
        if($this->validateGCaptcha() === false){

            return redirect()->back()
                             ->with('errors', 'Captcha validation failed')
                             ->withInput();

        }

        $user = new User( $this->request->getPost() );
        if($this->model->insert( $user )){

            #01: Load registered user
            $user = $this->model->getUser( $this->model->getInsertID() );

            #02: Check account status
            if(! $user->isActive()){

                #03: Create user token
                $userToken = $user->getToken();

                #04: Check email verification is enabled
                if( is_user_email_verification_enabled() ){

                    // Send verification link to mail
                    $emailVerification = new EmailVerification( $user );
                    $emailVerification->sendMail();

                    // User redirect to email confirmation page
                    return redirect()->to("/register/confirm?token={$userToken}");

                }else
                    // Check admin approval is enabled
                    if(is_user_admin_approval_enabled()) {

                    return redirect()->to("/register/wait?token={$userToken}");

                }
            }else{

                // Account is activated.
                $userPasswd = $this->request->getPost('password');
                if(service('auth')->login($user->username, $userPasswd)){

                    //redirect to dashboard
                    return redirect()->to('/user/dashboard');

                }

            }

            return redirect()->to('/login');
        }

        return redirect()->back()
                         ->with('errors', $this->model->errors())
                         ->withInput();
    }

    public function wait()
    {
        $title = 'Waiting for Approval ';

        $user = $this->getUserByToken();

        // Check account is already activated
        if($user->isAdminApproved() || $user->isActive()){

            // Check still admin approval is pending
            if($user->isPending() && is_user_email_verification_enabled() && ! $user->isEmailVerified()){

                // redirect to email confirmation msg page
                return redirect()->to('/register/confirm?token=' . $user->getToken());

            }

            //redirect to home
            return redirect()->to('/home');
        }

        return view(theme_path('/register/admin_approval'), compact('title'));
    }


    public function verify()
    {

        if($this->validate([
            'token' => 'required',
            'email' => 'required|valid_email'
        ])){

            $isVerified = false;

            $token = $this->request->getGet('token');
            $email = $this->request->getGet('email');

            #01: Attempt to find user by email
            $user = $this->model->findUserByEmail( $email );

            if($user !== null){

                #02: Check user email already verified or not
                if(! $user->isPending() || $user->isEmailVerified()){

                    //redirect to home page
                    return redirect()->to('/home');

                }

                #03: Attempt to verify token
                $emailVerify = new EmailVerification( $user );
                if($emailVerify->verify( $token, $user->id)){

                    // Email Verified
                    $isVerified = true;
                    $this->model->emailVerified( $user->id );

                    // Clear token
                    $emailVerify->clearToken( $token );

                    // Check still admin approval is pending
                    if( is_user_admin_approval_enabled() && ! $user->isAdminApproved()){

                        // redirect to admin approval msg page
                        return redirect()->to('/register/wait?token=' . $user->getToken());

                    }

                    // Activate account
                    if($this->model->activateAccount( $user->id )){

                        //Send Welcome Message to Email
                        service('mail_sender')->sendWelcomeMessage( $user );

                    }

                }

                if($isVerified) {

                        $title = 'Your email verified';
                        return view(theme_path('/register/email_verified'), compact('title'));

                }else{

                    $title = 'Email verification failed';
                    return view(theme_path('/register/email_not_verified'), compact('title'));

                }


            }

        }

        throw new PageNotFoundException();

    }

    protected function getUserByToken()
    {
        $token = $this->request->getGet('token');
        $user = null;

        if(! empty($token)){

            $userId = UniqToken::decode( $token );
            if(! empty($userId)){

                $user = $this->model->getUser( $userId );

            }

        }

        if($user === null){
            throw new PageNotFoundException('Invalid User Token');
        }

        return $user;
    }

    protected function validateGCaptcha(): ?bool
    {

        if( is_register_gcaptcha_enabled() ){

            helper('captcha');
            $success = false;
            $captchaResponse = $this->request->getPost('gcaptcha');
            if(! empty($captchaResponse)){
                if(validate_gcaptcha( $captchaResponse )){
                    $success = true;
                }
            }

            return $success;
        }

        return null;
    }

}