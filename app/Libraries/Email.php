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


class Email
{

    protected $template = null;
    protected $data = [];
    protected $bodyContent = null;
    public $base;

    public function __construct()
    {
        $this->base = \Config\Services::email();

        if(! empty(smtp_config('host'))){

            $config = [
                'SMTPHost' => smtp_config('host'),
                'SMTPUser' => smtp_config('user'),
                'SMTPPass' => smtp_config('pass'),
                'SMTPPort' => smtp_config('port'),
                'protocol' => 'smtp'
            ];

            $this->base->initialize($config);
        }

        //default sender mail
        $this->base->setFrom(get_config('email_address'), site_name());
        $this->base->setReplyTo('');

    }

    /**
     * Set Email Template
     * @param $template
     * @return $this
     */
    public function setTemplate( $template ): Email
    {
        $this->template = $template;
        return $this;
    }

    /**
     * Set data for mail
     * @param array $data
     * @return $this
     */
    public function setData(array $data): Email
    {
        $this->data = $data;
        return $this;
    }

    public function load(): bool
    {
        $templatePath = view_path('/email/' . $this->template, 'html');

        if($templatePath !== null){

            $content = @file_get_contents( $templatePath );
            $data    = $this->getData();

            foreach ($data as $key => $val) {
                $key = "{{ ". strtoupper( $key ) ." }}";
                $content = str_replace($key, $val, $content);
            }

            $this->base->setMessage( $content );

            return true;
        }

        return false;
    }

    public function isReady(): bool
    {
        return ! empty( get_config('email_address') );
    }

    public function getBodyContent()
    {
        return $this->bodyContent;
    }


    protected function getData(): array
    {
        $logo = site_name();
        helper('html');
        if(has_site_logo()){
            $logo = img(site_logo(), false, [
                'alt' => 'site logo',
                'width' => 170
            ]);
        }

        $defaultData = [
            'site_url' => site_url(),
            'site_name' => site_name(),
            'site_logo' => $logo
        ];

        return $defaultData + $this->data;

    }



}