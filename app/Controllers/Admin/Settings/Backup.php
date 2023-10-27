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


use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;

class Backup extends BaseSettings
{

    public function index()
    {
        $title = 'Backup';
        return view('admin/settings/backup', compact('title'));
    }


    public function get()
    {
        if($this->request->getMethod() !== 'post'){
            throw new PageNotFoundException();
        }

        $this->save( ['last_db_backup_at' => Time::now()->toDateTimeString()] );

        helper('backup');
        get_db_backup();
    }



}