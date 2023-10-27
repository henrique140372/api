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

class UniqVisit
{
    protected static $prepix = 'viewed_';
    protected static $uniqIdentityTokenName = '_identity';

    public static function isViewed( $uniqId ): bool
    {
        return get_cookie(self::getUniqName( $uniqId )) == 1;
    }

    public static function viewed( $uniqId, $path = '/'  )
    {
        if(! empty(get_cookie(self::getUniqName($uniqId), ))){
            $exp = 60 * 60 * \App\Models\VisitorsModel::VISIT_EXPIRING_HOURS;
            set_cookie(self::getUniqName($uniqId), 1, $exp , '', $path);
        }
    }

    public static function setUniqToken(): string
    {
        $token = self::getToken();
        set_cookie(self::$uniqIdentityTokenName, $token, 30);
        return $token;
    }

    public static function getUniqToken(): ?string
    {
        return get_cookie(self::$uniqIdentityTokenName);
    }

    public static function isValidUniqToken( $token , $autoDel = false): bool
    {
        $resp = ! empty($token) && $token == self::getUniqToken();
        if($resp){
            $cachedId =  self::$uniqIdentityTokenName . "_{$token}";
            $cached = cache()->get( $cachedId );
            if($cached === null){
                cache()->save($cachedId , 1, 60 * 30);
            }else{
                $resp = false;
            }
        }
        if($autoDel){
            self::delUniqToken();
        }

        return $resp;
    }

    public static function delUniqToken()
    {
        delete_cookie( self::$uniqIdentityTokenName );
    }


    public static function getUniqName( $uniqId ): string
    {
        return self::$prepix . $uniqId;
    }



    public static function getToken(): string
    {
        return sha1(mt_rand(1, 90000) . 'SALT');
    }





}