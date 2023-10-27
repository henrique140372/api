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


class Player extends BaseSettings
{

    public function index()
    {
        $title = 'Player Settings';
        return view('admin/settings/player', compact('title'));
    }


    public function update()
    {

        if($this->request->getMethod() == 'post') {

            $data = $this->request->getPost();

            $data['player_autoplay'] =  isset( $data['player_autoplay'] );
            $data['player_title'] =  isset( $data['player_title'] );
            $data['player_home_page_btn'] =  isset( $data['player_home_page_btn'] );
            $data['color_dot_on_player_links'] =  isset( $data['color_dot_on_player_links'] );

            return $this->save( $data );

        }

        return redirect()->back();

    }

    public function clean()
    {
        cache()->clean();
        return redirect()->back();
    }


}