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


use CodeIgniter\Exceptions\PageNotFoundException;

class Language extends BaseController
{
    public function index($lang = '')
    {

        //check multi languages is enabled or not
        if(! is_multi_languages_enabled()){
            throw new PageNotFoundException('Multi language feature not enabled');
        }

        $session = session();
        $locale = $this->request->getGet('l');

        //set selected language in session
        $session->remove('lang');
        $session->set('lang', $locale);

        //redirect back
        $redirectUrl = $this->request->getGet('redirect');
        if(strpos($redirectUrl, base_url()) === false || strpos($redirectUrl, base_url() . '/lang') !== false){
            $redirectUrl = base_url();
        }

        //redirect back
        return redirect()->to( $redirectUrl )
                         ->setCookie('lang', $locale, 60 * 60 * 24 * 360);
    }
}
