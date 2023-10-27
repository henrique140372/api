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
use App\Models\UserModel;

class Profile extends BaseController
{

    protected $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function index()
    {
        $title = 'My Profile';

        return view(theme_path('/user/profile'), compact('title'));
    }


    public function update()
    {
        $user = current_user();
        $username = $this->request->getPost('username');
        if(! empty($username)) $user->username = $username;

        //Attempt to Update username if is it changed
        if($user->hasChanged('username')){

            if($this->model->save( $user )){

                //update current user session
                session()->set('username', $user->username);

                return redirect()->back()
                                 ->with('success', 'Username has been successfully changed');

            }

            return redirect()->back()
                             ->with('errors', $this->model->errors());

        }

        //Attempt to change password
        $oldPasswd = $this->request->getPost('old_passwd');
        $newPasswd = $this->request->getPost('new_passwd');
        $confirmPasswd = $this->request->getPost('confirm_passwd');

        if(! empty($oldPasswd) && ! empty($newPasswd)){

            //verify old passwd
            if(! $user->verifyPassword( $oldPasswd )){

                return redirect()->back()
                                 ->with('errors', 'Old password is incorrect');

            }

            //Attempt to change passwd
            $user->password = $newPasswd;
            $user->confirm_password = $confirmPasswd;
            if(! $this->model->save( $user )){

                return redirect()->back()
                                 ->with('errors', $this->model->errors());

            }


            return redirect()->back()
                             ->with('success', 'Password has been successfully changed');
        }

        //Attempt to update 2FA
        $is2FaEnabled = $this->request->getPost('2fa') !== null ? '1' : '0';
        $user->is_2fa_login = $is2FaEnabled;

        if($user->hasChanged('is_2fa_login')){

           if($this->model->save( $user )){

               $e = $is2FaEnabled ? 'enabled' : 'disabled';
               return redirect()->back()
                                ->with('success', 'Two-factor authentication ' . $e);

           }

            return redirect()->back()
                             ->with('errors', 'Something went wrong');
        }


        return redirect()->back();

    }

}