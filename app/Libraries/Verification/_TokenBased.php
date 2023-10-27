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

class _TokenBased
{

    protected $user = null;
    protected $tokenModel;
    protected $token = null;
    protected $type  = null;
    protected $maxMails = 3;
    protected $baseLink = '';
    protected $tokenId = null;

    public function __construct()
    {
        $this->tokenModel = new AuthTokenModel();
    }


    protected function saveToken(): bool
    {
        $data = [
            'parent_id' => $this->user->id,
            'token'     => $this->token,
            'type'      => $this->type
        ];

        if($this->tokenModel->insert( $data )){
            $this->tokenId = $this->tokenModel->getInsertID();
            return true;
        }

        return false;
    }


    public function verify( $tokenData, $pId = null ): bool
    {
        $verified = false;
        $token = $this->tokenModel->_type( $this->type )
                                  ->getToken( $tokenData );

        if($token !== null && ! $token->isExpired()){

            if($pId !== null){

                if($token->parent_id == $pId){

                    $verified = true;

                }

            }else{

                $verified = true;

            }

        }

        $this->_tmpToken = $token;
        return $verified;
    }


    public function clearToken( $tokenData )
    {
        return $this->tokenModel->_type( $this->type )
                                ->removeToken( $tokenData );
    }

    public function isMaxSendMails(): bool
    {
        return $this->maxMails <= $this->getNumOfSendMails();
    }

    public function getNumOfSendMails(): int
    {
        $results = $this->tokenModel->_type( $this->type )
                                    ->getActiveTokensByParentId( $this->user->id );

        return count( $results );
    }


    public function getTokenId()
    {
        return $this->tokenId;
    }

    protected function createToken()
    {
        $this->token = bin2hex(random_bytes(30));
        return $this->saveToken();
    }

    protected function getVerificationLink(): string
    {
        return site_url("{$this->baseLink}?" . http_build_query([
                'token' => $this->token,
                'email' => $this->user->email
            ]));
    }

}