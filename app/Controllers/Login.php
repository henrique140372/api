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


use App\Libraries\Authentication;
use App\Libraries\UniqToken;
use App\Libraries\Verification\PasswdResetVerification;
use App\Libraries\Verification\TwoFaVerification;
use App\Libraries\VisitorInfo\VisitorInfo;
use App\Models\AuthTokenModel;
use App\Models\LoginActivityModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\DebugTraceableTrait;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;
use Config\Services;

class Login extends BaseController
{

    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        $title = lang("Login.page_title");

        return view(theme_path('/login/login'), compact('title'));
    }

    public function check()
    {
        if($this->request->getMethod() != 'post'){
            throw new PageNotFoundException();
        }

        // G Captcha validation
        if( is_login_gcaptcha_enabled() ){

            if(! $this->checkGCaptcha()){
                return redirect()->back()
                                 ->with('errors', 'Captcha validation failed');
            }

        }


        $authentication = new Authentication();

        #01: Get username and password
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        #02: Check username and password is not empty
        if(! empty($username) && ! empty($password)){

            #03: Attempt to login
            if($authentication->blockAdminLogin()
                             ->login($username, $password)){

                // LOGIN SUCCESS: return to user's dashboard
                return redirect()->to('/user/dashboard');


            }else{

                // LOGIN FAILED: redirect to back
                return redirect()->back()
                                 ->with('errors', $authentication->getError());

            }

        }

        return redirect()->back()
                         ->with('errors', 'Username and password is required');
    }

    public function reset_password()
    {
        $title = 'Forgot your password?';

        if($this->request->getMethod() == 'post'){

            $username = $this->request->getPost('username');
            $error = '';

            if(! empty($username)){

                #01: Attempt to get user by email or username
                $user = $this->model->_user()
                                    ->findUserByUsernameOrEmail( $username );

                if($user !== null){

                    $passwdResetVerification = new PasswdResetVerification( $user );

                    #02: Check already active requests
                    if(! $passwdResetVerification->isMaxSendMails()){

                        #03: Attempt to send password verification link to mail
                        $passwdResetVerification->sendMail();

                        return redirect()->back()
                                         ->with('success', 'Check your email for password reset instructions');

                    }else{

                        $error = 'Too many requests. Try again later';

                    }

                }else{

                    $error = 'The requested user could not be found.';

                }

            }else{

                $error = 'Username or Email is required';

            }

            return redirect()->back()
                             ->with('errors', $error);

        }

        return view(theme_path('/login/reset_password'), compact('title'));
    }

    public function change_password()
    {
        $title = 'Create new password';
        $isVerified = false;

        if($this->validate([
            'token' => 'required',
            'email' => 'required|valid_email'
        ])){

            $token = $this->request->getGet('token');
            $email = $this->request->getGet('email');

            #01: Attempt to find user by email
            $user = $this->model->findUserByEmail( $email );

            if($user !== null){

                #03: Attempt to verify token
                $passwdResetVerification = new PasswdResetVerification( $user );
                if($passwdResetVerification->verify( $token, $user->id )){

                    // Request Verified
                    $isVerified = true;

                    #04: Attempt to change password
                    if($this->request->getMethod() == 'post'){

                        //change password
                        $user->fill( $this->request->getPost() );
                        if($this->model->updatePassword( $user )){

                            //PASSWD HAS BEEN SUCCESSFULLY UPDATED

                            // clear token
                            $passwdResetVerification->clearToken( $token );

                            //Attempt to login user
                            if(service('auth')->login($user->username, $user->password)){

                                return redirect()->to('user/dashboard')
                                                 ->with('success', 'Your Password has been reset');

                            }

                            // Redirect to login page
                            return redirect()->to('/login')
                                             ->with('errors', service('auth')->getError());

                        }else{

                            return redirect()->back()
                                             ->with('errors', $this->model->errors());

                        }

                    }

                }

            }

        }

        if(! $isVerified){
            throw new PageNotFoundException();
        }

        return view(theme_path('/login/change_password'), compact('title'));
    }



    public function twofa()
    {
        $title = 'Device Verification';

        #01: Decode token data
        $tokenData = UniqToken::decode( $this->request->getGet('token') );
        if($tokenData !== null && count($tokenData) == 2){

            #02: Extract token data
            list($userId, $tokenId) = $tokenData;

            #03: Attempt to get user and token
            $user = $this->model->getUser( $userId );
            $activeToken = model('AuthTokenModel')->where('id', $tokenId)
                                                        ->_type( AuthTokenModel::TYPE_2FA )
                                                        ->select('id')
                                                        ->first();

            // Check user and token
            if($user == null || $activeToken == null){

                // Request not allowed
                throw new PageNotFoundException('Bad request');

            }

            #04: Process with submitted authentication code
            if($this->request->getMethod() == 'post'){

                $code = $this->request->getPost('code');
                if(! empty($code)){

                    // Restrict a code verifications per user
                    $throttle = Services::throttler();
                    if(! $throttle->check(md5( $user->id . '_2fa'), 3, DAY)){
                        //too many requests
                        return redirect()->back()
                                         ->with('errors', 'Too many requests. Try again later');
                    }

                    // Attempt to verify code
                    $twoFa = new TwoFaVerification( $user );
                    if($twoFa->verify($code, $user->id)){

                        // Save login activity
                        $visitorInfo = new VisitorInfo();
                        $ip = $visitorInfo->getIp();
                        $browser = $visitorInfo->getBrowser();
                        $platform = $visitorInfo->getPlatform();

                        if(! empty($ip) && ! empty($browser) && ! empty($platform)){

                            $loginActivity = new LoginActivityModel();
                            $data = [
                                'user_id'   => $user->id,
                                'browser'   => $browser,
                                'platform'  => $platform,
                                'ip'        => $ip,
                                'logged'    => Time::now()->toDateTimeString()
                            ];

                            // Attempt to clean old activity
                            $loginActivity->cleanOldActivity( $user->id );

                            // Attempt to insert login activity
                            $loginActivity->insert( $data );

                        }

                        //clear tokens
                        $twoFa->clearToken( $code );

                        //Attempt to login user
                        if(service('auth')->login($user->username, null, false, true)){

                            return redirect()->to('user/dashboard');

                        }

                        // Redirect to login page, if something went wrong
                        return redirect()->to('/login');

                    }

                    // Verification failed, redirect back
                    return redirect()->back()
                                     ->with('errors', 'Verification code has been expired or invalid');

                }else{

                    return redirect()->back()
                                     ->with('errors', 'Verification code is required');

                }

            }

            $email = $user->email;
            return view(theme_path('/login/twofa'), compact('title', 'email'));
        }

        // Request not allowed
        throw new PageNotFoundException('Bad request');
    }

    protected function checkLoginActivity()
    {

    }

}