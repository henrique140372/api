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



class Api extends BaseSettings
{

    public function index()
    {
        $title = 'API Settings';

        $topBtnGroup = create_top_btn_group([
            'admin/settings/api/doc' => 'View Doc'
        ]);


        return view('admin/settings/api', compact('title', 'topBtnGroup'));
    }

    public function doc()
    {
        $title = 'API Documentation';

        return view('admin/settings/api_doc', compact('title'));
    }


    public function generate()
    {
        $newKey = random_string(18);

        $this->save([
            'dev_apikey' => $newKey
        ]);

        return redirect()->back()
                         ->with('success', 'API Key generated successfully');
    }

    public function update()
    {

        if ($this->request->getMethod() == 'post') {


            $data['dev_api'] =  ! empty( $this->request->getPost('dev_api') );

            return $this->save( $data );

        }

        return redirect()->back();

    }

}