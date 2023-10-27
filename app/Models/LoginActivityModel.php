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

use App\Libraries\VisitorInfo\VisitorInfo;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class LoginActivityModel extends Model
{

    protected $table = 'login_activity';
    protected $returnType = 'App\Entities\LoginActivity';
    protected $allowedFields = ['user_id', 'browser', 'platform', 'ip', 'logged'];
    protected $validationRules = [
        'user_id' => 'required|is_natural_no_zero|exist[users.id]',
        'browser' => 'required',
        'platform' => 'required',
        'ip'       => 'required|valid_ip',
        'logged'   => 'required'
    ];


    protected $maxActivities = 10;


    public function getByUserId(int $userId)
    {
        return $this->_user( $userId )
                    ->findAll();
    }

    public function cleanOldActivity(int $userId)
    {
        $activities = $this->orderBy('logged', 'ASC')
                           ->getByUserId($userId);

        if(! empty($activities) && count( $activities ) + 1 >= $this->maxActivities){

            $oldestActivity = array_shift($activities);
            $this->delete( $oldestActivity->id );

        }
    }

    public function getLoginActivityByRequest(int $userId)
    {
        $visitorInfo = new VisitorInfo();

        // Get visitor Info
        $ip = $visitorInfo->getIp();
        $browser = $visitorInfo->getBrowser();
        $platform = $visitorInfo->getPlatform();

        if(empty($ip) || empty($browser) || empty($platform)){
            return null;
        }

        return $this->_user( $userId )
                    ->_ipAddress( $ip )
                    ->_browser( $browser )
                    ->_platform( $platform )
                    ->first();
    }

    public function isNewLoginActivity(int $userId): bool
    {
        return $this->getLoginActivityByRequest( $userId ) === null;
    }

    public function saveLoginActivity(\App\Entities\User $user)
    {
        $request = service('request');
return;
        $loginActivity = $this->getLoginActivityByRequest( $user->id );

        if($loginActivity === null){

            //check is this not user's first login attempt
            if(! $user->isFirstLogin()){

                // save login activity


                // Attempt to clean old activity
                $this->cleanOldActivity( $user->id );

                // Attempt to insert login activity
                $this->insert( $data );

            }

        }

    }

    public function _user(int $userId)
    {
        return $this->where('user_id', $userId);
    }

    public function _browser( $browser )
    {
        return $this->where('browser', $browser);
    }

    public function _platform( $platform )
    {
        return $this->where('platform', $platform);
    }

    public function _ipAddress( $ip )
    {
        return $this->where('ip', $ip);
    }


}