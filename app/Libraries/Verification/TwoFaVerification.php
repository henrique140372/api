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

namespace App\Libraries\Verification;

use App\Models\AuthTokenModel;


class TwoFaVerification extends _TokenBased
{

    protected $user;


    public function __construct(\App\Entities\User $user)
    {
        parent::__construct();
        $this->user = $user;
        $this->type = AuthTokenModel::TYPE_2FA;
    }


    public function sendMail()
    {
        #01: Create Token
        if($this->createToken()){

            service('mail_sender')
                  ->send2FaAuthenticationCode($this->user, $this->token);

        }

    }

    public function cleanAllActiveTokens()
    {
        $this->tokenModel->_type( $this->type )
                         ->where('parent_id', $this->user->id)
                         ->delete();

        return $this;
    }

    protected function createToken()
    {
        $this->token = bin2hex(random_bytes(3));
        return $this->saveToken();
    }


}