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

namespace App\Libraries;

use CodeIgniter\Encryption\Encryption;

class UniqToken
{

    protected static $separator = '--';


    public static function create( $data )
    {

        $token = null;

        if(is_array( $data )) {
            $data = implode(self::$separator, $data);
        }

        try{

            $token =  service('encrypter')->encrypt( $data );
            $token = bin2hex( $token );

        }catch (\Exception $e){ }

        return $token;
    }


    public static function decode( $token )
    {
        $data = null;

        try{

            $data = service('encrypter')->decrypt( hex2bin( $token ) );
            $data = explode(self::$separator, $data);

        }catch (\Exception $e) { }

        return $data;
    }



}