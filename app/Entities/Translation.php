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


class Translation extends \CodeIgniter\Entity\Entity
{


    public function getLangName()
    {
        if(! empty( $this->lang )){

            $languages = get_lang_list();
            if(! empty( $languages ) && array_key_exists( $this->lang, $languages )){

                return $languages[$this->lang];

            }

        }

        return 'Unknown Language';
    }

}