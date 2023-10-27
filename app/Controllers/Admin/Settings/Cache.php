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


class Cache extends BaseSettings
{

    public function index()
    {
        $title = 'Cache Settings';
        return view('admin/settings/cache', compact('title'));
    }


    public function update()
    {

        if($this->request->getMethod() == 'post') {

            if($this->validate([
                'web_page_cache_duration' => 'required|is_natural|greater_than[59]'
            ])){

                $data = $this->request->getPost([
                    'web_page_cache',
                    'web_page_cache_duration',
                    'cached_pages'
                ]);
                $data['web_page_cache'] =  isset( $data['web_page_cache'] );
                $data['cached_pages']   = json_encode($data['cached_pages']);

                return $this->save( $data );

            }

            return redirect()->back()
                            ->with('errors', $this->validator->getErrors());

        }

        return redirect()->back();

    }

    public function clean()
    {
        cache()->clean();
        return redirect()->back();
    }


}