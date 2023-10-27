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

namespace App\Libraries\VisitorInfo;


/**
 * Class VisitorInfo
 * @package App\Libraries
 */
class VisitorInfo {

    /**
     * Visitor IP Address
     * @var string
     */
    protected $ipAddress = null;

    /**
     * Geo plugin data
     * @var array
     */
    protected $geoData = [];

    protected $browser = null;
    protected $platform = null;
    protected $userAgent = null;

    /**
     * VisitorInfo constructor.
     */
    public function __construct(){

        $this->init();

    }

    /**
     * init visitor info
     * @return bool
     */
    public function init()
    {
        //detect browser
        $request = service('request');
        $this->ipAddress = $request->getIPAddress() ?? null;
        $this->browser = $request->getUserAgent()->getBrowser() ?? null;
        $this->platform = $request->getUserAgent()->getPlatform() ?? null;
        $this->userAgent = $request->getUserAgent()->getAgentString() ?? null;

        if(isDevelopmentMode()  && $this->ipAddress == '::1'){
            $this->ipAddress = '123.231.125.122';
        }

    }

    /**
     * Get user ip address
     * @return string|null
     */
    public function getIp(): ?string
    {
        return $this->ipAddress;
    }

    /**
     * Get user ip address
     * @return string|null
     */
    public function getBrowser(): ?string
    {
        return $this->browser;
    }

    /**
     * Get user agent
     * @return string|null
     */
    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    /**
     * Get user ip address
     * @return string|null
     */
    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    /**
     * get user country code
     * @return string
     */
    public function getCountryCode() : string{
        return $this->getGeoData('country');
    }


    /**
     * Get user timezone
     * @return string
     */
    public function getTimezone() : string{
        return $this->getGeoData('timezone');
    }


    /**
     * Get geo plugin data
     * @param string $field
     * @return string
     */
    private function getGeoData(string $field) : string{
        return $this->geoData[$field] ?? '';
    }


    public function loadGeoData()
    {

        $response = @file_get_contents("http://ipinfo.io/" . $this->ipAddress);

        if(!empty($response) && isJson($response)){

            $ipData = json_decode($response, true);
            $this->geoData = $ipData;


        }

        return $this;
    }


}