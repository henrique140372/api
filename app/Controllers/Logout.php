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


class Logout extends BaseController
{

    public function index(): \CodeIgniter\HTTP\RedirectResponse
    {
        //unset session
        session()->remove('is_logged');
        session()->remove('user_id');
        session()->remove('username');

        //redirect user
        $redirect = ! empty( $_GET['rd_back'] ) ? previous_url() : '/home';
        return redirect()->to( $redirect );
    }

}