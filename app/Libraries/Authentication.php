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

use App\Entities\User;
use App\Libraries\Verification\TwoFaVerification;
use App\Models\LoginActivityModel;
use App\Models\UserModel;



class Authentication
{

    private static $user = null;
    protected $userModel;
    protected $error = '';
    protected $isAdminLoginBlocked = false;
    protected $isUserLoginBlocked = false;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }


    public function login($username, $password, $check2Fa = true, $bypassPasswd = false): bool
    {
        if($this->isAdminLoginBlocked){
            $this->userModel->where('role !=', UserModel::ROLE_ADMIN);
        }

        if($this->isUserLoginBlocked){
            $this->userModel->where('role !=', UserModel::ROLE_USER);
        }

        $user = $this->userModel->findUserByUsernameOrEmail( $username );
        $isLogged = false;
        $isPasswdBypassed = $bypassPasswd && empty($password);

        if($user !== null){

            #01. Verify password
            if($isPasswdBypassed || $user->verifyPassword( $password )){

                #02: Check account status
                if($this->isUserStatusPassed( $user )){

                    #03: Check 2FA login enabled or not, If yes check login activity
                    if( $check2Fa ) $this->check2FaAuth( $user );

                    #04: Login user
                    $session = session();
                    $session->regenerate();

                    $session->set('is_logged', 1);
                    $session->set('user_id', $user->id);
                    $session->set('username', $user->username);

                    $isLogged = true;

                    #04: Update login activity
                    $this->userModel->logged( $user->id );

                }

            }

        }


        if(! $isLogged && empty($this->error)){
            $this->error = 'Invalid username or password';
        }

        return $isLogged;
    }


    public function blockAdminLogin()
    {
        $this->isAdminLoginBlocked = true;
        return $this;
    }

    public function blockUserLogin()
    {
        $this->isUserLoginBlocked = true;
        return $this;
    }

    protected function check2FaAuth(\App\Entities\User $user)
    {

        if( $user->is2FaLoginEnabled() && ! $user->isFirstLogin()){

            // Check login activity
            $loginActivityModel = new LoginActivityModel();
            if($loginActivityModel->isNewLoginActivity( $user->id )){

                // New login activity detected.
                //Attempt to send 2FA auth code to user's mail
                $twoFa = new TwoFaVerification( $user );
                $twoFa->cleanAllActiveTokens()
                      ->sendMail();

                // Get token Id to create uniq token for 2fa
                $tokenId = $twoFa->getTokenId();
                $token = null;
                if(! empty($tokenId)){

                    $tokenData = [$user->id, $tokenId];
                    $token = UniqToken::create( $tokenData );

                }

                // Redirect to 2FA authentication page
                header("HTTP/1.1 301 Moved Permanently");
                header('Location: ' . site_url('/login/twofa?token=' . $token));
                exit;

            }

        }
    }

    protected function isUserStatusPassed( $user ): bool
    {
        $logStatusPassed = false;

        // Check pending status
        if($user->isPending()){

            if( is_user_email_verification_enabled() || is_user_admin_approval_enabled() ){

                $this->error = 'Your account is not activated yet';

            }else{

                $logStatusPassed = true;

            }

        }

        // Check blocked status
        if($user->isBlocked()){
            $this->error = 'Your Account has been blocked';
        }

        // Check active status
        if($user->isActive()){
            $logStatusPassed = true;
        }

        return $logStatusPassed;
    }


    public function loadCurrentUser(): bool
    {
        if($this::$user === null){

            $userId = session()->get('user_id');
            $username = session()->get('username');

            if(! empty($userId)){

                $user = $this->userModel->getUser( $userId );

                if($user !== null){

                    // Verify username again
                    if($user->verifyUsername( $username )){
                        $this::$user = $user;
                    }

                }

            }

        }

        return $this::$user !== null;
    }




    public function getError(): string
    {
        return $this->error;
    }


    public static function getLoggedUser(): ?User
    {
        return self::$user !== null ? self::$user : new User();
    }

    public static function isLogged(): bool
    {
        return session()->get('is_logged') == 1;
    }

}