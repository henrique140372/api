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

class Firewall extends BaseSettings
{

    public function index()
    {
        $title = 'Firewall Settings';
        return view('admin/settings/firewall', compact('title'));
    }


    public function update()
    {

        if($this->request->getMethod() == 'post') {

            $validationRules = [
                'stream_links_requests_limit' => 'permit_empty|is_natural',
                'download_links_requests_limit' => 'permit_empty|is_natural',
                'api_status_check_rate_limit' => 'permit_empty|is_natural',
                'report_requests_limit' => 'permit_empty|integer|is_natural_no_zero',
            ];

            if($this->validate( $validationRules )) {

                $data = $this->request->getPost();

                $data['is_referer_blocked'] =  isset( $data['is_referer_blocked'] );
                $data['allowed_referer_list'] = separate_by_comma( $data['allowed_referer_list'] );

                return $this->save( $data );

            }

            return redirect()->back()
                ->with('errors', $this->validator->getErrors());

        }

        return redirect()->back();

    }

}