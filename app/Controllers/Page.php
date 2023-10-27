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


use App\Models\PagesModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Page extends BaseController
{

    public function index($slug = '')
    {
        if(! empty( $slug )){

            $metaKeywords = $metaDescription = '';

            $pageModel = new PagesModel();
            $page = $pageModel->getPageBySlug( $slug );

            if($page !== null){

                if($page->isSystemPage() && ! empty($page->real_page)){
                    return redirect()->to($page->real_page);
                }

                $title = $page->title;
                $metaKeywords = $page->meta_keywords;
                $metaDescription = $page->meta_description;

                return view(theme_path('page'), compact('page','metaKeywords', 'metaDescription',  'title'));
            }

        }

        throw new PageNotFoundException();
    }



}
