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


use App\Models\LinkModel;
use CodeIgniter\Model;

class Servers extends BaseSettings
{

    public function index()
    {
        $title = 'Servers Settings';

        $linksModel = new LinkModel();
        $distLinks = $linksModel->select('link')
                                ->distinct()
                                ->findAll();

        $servers = get_config('renamed_servers');

        if(! empty($distLinks)){

            foreach ($distLinks as $link) {
                $host = $link->getHost();
                if(! empty($host)){
                    if(! isset( $servers[$host] )){
                        $servers[$host] = '';
                    }
                }
            }

        }

        $serverOptions = [];
        if(! empty( $servers )){
            foreach ($servers as $key => $val) {
                if(! empty($val)){
                    $serverOptions[$val] = $val;
                }else{
                    $serverOptions[$key] = $key;
                }
            }
        }


        return view('admin/settings/servers', compact('title', 'servers', 'serverOptions'));
    }


    public function update()
    {


        if($this->request->getMethod() == 'post'){

            if($this->validate([
                'servers.*' => 'permit_empty|alpha_numeric_punct',
                'default_server' => 'permit_empty|alpha_numeric_punct',
                'anonymous_stream_server_name' => 'permit_empty|alpha_numeric_space'
            ])){

                $servers = $this->request->getPost('renamed_servers');
                $servers = array_map('trim', $servers);

                $default_server = $this->request->getPost('default_server');
                $servers = is_array($servers) ? json_encode($servers) : NULL;

                $isAnonsServerNameEnabled =  $this->request->getPost('is_use_anonymous_stream_server') !== null;
                $anonServerName =  $this->request->getPost( 'anonymous_stream_server_name' );


                $data = [
                    'renamed_servers' => $servers,
                    'default_server' => $default_server,
                    'is_use_anonymous_stream_server' => $isAnonsServerNameEnabled,
                    'anonymous_stream_server_name' => $anonServerName
                ];

                return $this->save( $data );

            }

        }


        return redirect()->back();

    }

}