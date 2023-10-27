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

namespace App\Entities;


class Page extends \CodeIgniter\Entity\Entity
{

    protected $casts = [
        'content' => 'base64'
    ];

    protected $castHandlers = [
        'base64' => \App\Entities\Cast\CastBase64::class
    ];

    public function isPublic(): bool
    {
        return $this->status == 'public';
    }


    public function isSystemPage(): bool
    {
        return $this->is_system_page == 1;
    }

}