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

namespace App\Models;


use CodeIgniter\Model;


class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $allowedFields = ['value'];
    protected $returnType = 'App\Entities\Setting';
    protected $primaryKey = 'name';

    public function getConfig( $name )
    {
        if(empty($name))
            return null;

        return $this->where('name', $name)
                    ->first();
    }





}