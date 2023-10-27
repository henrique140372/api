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

class Login extends BaseController
{
    public function index()
    {
        $title = 'ADM';

        //redirect already logged admin to dashboard
        if(service('auth')->isLogged()){
            return redirect()->to('/admin');
        }

        if($this->request->getMethod() == 'post')
        {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');

            if(service('auth')->blockUserLogin()
                                    ->login($username, $password, false)){

                //redirect to dashboard
                return redirect()->to('/admin/dashboard');

            }

            return redirect()->back()
                             ->with('error', 'Invalid username or password')
                             ->withInput();

        }

        return view('admin/auth/login', compact('title'));
    }
    
}