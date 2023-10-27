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

use App\Models\AdminModel;
use App\Models\UserModel;
use CodeIgniter\Model;


class Profile extends BaseSettings
{


    public function index()
    {
        $title = 'Profile Settings';

        $usersModel = new UserModel();
        $admin = current_user();

        return view('admin/settings/profile', compact('title', 'admin'));
    }


    public function update()
    {
        $usersModel = new UserModel();
        $user = current_user();
        $username = $this->request->getPost('username');
        if(! empty($username)) $user->username = $username;

        //Attempt to Update username if is it changed
        if($user->hasChanged('username')){

            if($usersModel->save( $user )){

                //update current user session
                session()->set('username', $user->username);

            }else{

                return redirect()->back()
                    ->with('errors', $usersModel->errors());

            }

        }

        //update email
        $email = $this->request->getPost('email');
        if(! empty($email)) $user->email = $email;

        //Attempt to Update username if is it changed
        if($user->hasChanged('email')){

            if(! $usersModel->save( $user )){

                //update current user session
                return redirect()->back()
                                 ->with('errors', $usersModel->errors());

            }

        }

        //Attempt to change password
        $oldPasswd = $this->request->getPost('old_password');
        $newPasswd = $this->request->getPost('new_password');
        $confirmPasswd = $this->request->getPost('confirm_password');

        if(! empty($oldPasswd) && ! empty($newPasswd)){

            //verify old passwd
            if(! $user->verifyPassword( $oldPasswd )){

                return redirect()->back()
                    ->with('errors', 'Old password is incorrect');

            }

            //Attempt to change passwd
            $user->password = $newPasswd;
            $user->confirm_password = $confirmPasswd;
            if(! $usersModel->save( $user )){

                return redirect()->back()
                    ->with('errors', $usersModel->errors());

            }

        }

        return redirect()->back()
                         ->with('success', 'Your profile has been successfully changed');

    }

}