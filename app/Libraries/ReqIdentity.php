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

/**
 * Class ReqIdentity
 * @package App\Libraries
 * @author John Antonio
 */
class ReqIdentity
{

    /**
     * User IP address
     * @var string|null
     */
    protected $userIp = null;

    /**
     * Unique key to identity
     * @var string|null
     */
    protected $key = null;

    /**
     * User identity token
     * @var string|null
     */
    protected $token = null;

    /**
     * Identity expiring duration
     * @var int
     */
    protected $expire = 60 * 60 * 24; //24 hours


    public function __construct( $key )
    {
        $request = \Config\Services::request();

        $this->userIp = $request->getIPAddress();
        $this->key = $key;

        $this->initToken();
    }

    public function isNew(): bool
    {
        return empty( cache()->get( $this->token ) );
    }

    public function detect()
    {
        cache()->save($this->token, 'user_detected',  $this->expire);
    }

    public function setExpire(int $expire )
    {
        $this->expire = $expire;
    }

    protected function initToken()
    {
        $this->token = md5( $this->userIp . $this->key);
    }

}