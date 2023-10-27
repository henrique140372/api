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


class Contact extends BaseController
{

    public function index()
    {
        $title = 'Contact us';
        $customTxt = '';
        $metaKeywords = $metaDescription = '';

        $page = model('PagesModel')->getSystemPage('contact-us');
        if($page !== null){

            $title = $page->title;
            $customTxt = $page->content;

            $metaKeywords = $page->meta_keywords;
            $metaDescription = $page->meta_description;

        }

        // cache page
        $this->cacheIt('contact_us');

        $data = compact('title', 'customTxt','metaKeywords', 'metaDescription');
        return view(theme_path('/contact-us'), $data);
    }

    public function send_message()
    {
        if (!$this->request->getMethod() == 'post') {
            throw new PageNotFoundException();
        }

        // G Captcha validation
        if( is_contact_gcaptcha_enabled() ){

            if(! $this->checkGCaptcha()){
                return redirect()->back()
                                 ->with('errors', 'Captcha validation failed');
            }

        }

        if ($this->validate([
            'name' => 'required|alpha|max_length[50]',
            'email' => 'required|valid_email|max_length[128]',
            'message' => 'required|min_length[10]'
        ])) {

            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $message = $this->request->getPost('message');

            if (service('mail_sender')->sendMessageToAdmin($name, $email, $message)) {

                return redirect()->back()
                    ->with('success', 'Message has been sent successfully');

            }

            return redirect()->back()
                ->with('errors', 'Something went wrong')
                ->withInput();
        }

        return redirect()->back()
            ->with('errors', $this->validator->getErrors())
            ->withInput();
    }




}
