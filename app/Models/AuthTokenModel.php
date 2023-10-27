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

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class AuthTokenModel extends Model
{

    protected $table            = 'tokens';
    protected $returnType       = 'App\Entities\Token';
    protected $allowedFields    = ['parent_id','token','type','expired'];

    protected $validationRules  = [
        'parent_id' => 'permit_empty|is_natural_no_zero',
        'token'     => 'required',
        'type'     => 'required|in_list[email_verification,password_reset,twofa]'
    ];

    protected $beforeInsert = ['setExpiringTime'];

    public const TYPE_EMAIL_VERIFY = 'email_verification';
    public const TYPE_RESET_PASSWD = 'password_reset';
    public const TYPE_2FA = 'twofa';

    public const EXPIRING_EMAIL_VERIFY = 30;
    public const EXPIRING_RESET_PASSWD = 15;
    public const EXPIRING_2FA = 10;


    protected function setExpiringTime($data): array
    {
        if(isset( $data['data'] )){
            $expMin = 5;
            switch ($data['data']['type']) {
                case $this::TYPE_EMAIL_VERIFY:
                    $expMin = $this::EXPIRING_EMAIL_VERIFY;
                    break;
                case $this::TYPE_RESET_PASSWD:
                    $expMin = $this::EXPIRING_RESET_PASSWD;
                    break;
                case $this::TYPE_2FA:
                    $expMin = $this::EXPIRING_2FA;
                    break;
            }
            $expired = strtotime(Time::now()->toDateTimeString() . "+{$expMin}minutes");
            $data['data']['expired'] =  date("Y-m-d H:i:s", $expired);
        }

        return $data;
    }

    public function getActiveTokensByParentId(int $pId)
    {
        return $this->where('parent_id', $pId)
                    ->where('DATE_FORMAT(expired, "%Y-%m-%d %H:%i:%s") >', Time::now()->toDateTimeString())
                    ->findAll();
    }


    public function getToken( $token )
    {
        return $this->where('token', $token)
                    ->first();
    }

    public function removeToken( $token )
    {
        return $this->where('token', $token)
                    ->delete();
    }

    public function _type( $type ): AuthTokenModel
    {
        return $this->where('type', $type);
    }










}