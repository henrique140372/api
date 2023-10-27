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

use CodeIgniter\Exceptions\DebugTraceableTrait;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

/**
 * Class UserModel
 * @package App\Models
 * @author John Antonio
 */
class UserModel extends Model
{
    protected $table = 'users';
    protected $returnType = 'App\Entities\User';
    protected $allowedFields = ['username', 'email', 'password', 'is_2fa_login'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'username' => 'required|alpha_numeric|min_length[4]|is_unique[users.username]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]|matches[confirm_password]',
        'is_2fa_login' => 'permit_empty|is_natural',
    ];

    protected $validationMessages = [
        'password' => [
            'matches' => 'Your password and confirmation password does not match'
        ],
        'username' => [
            'is_unique' => 'The username is already taken. please choose another one'
        ],
        'email' => [
            'is_unique' => 'The email is already used. please choose another one'
        ]
    ];

    protected $beforeInsert = ['hashPassword','setUserStatus'];
    protected $beforeUpdate = ['hashPassword'];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_PENDING = 'pending';
    public const STATUS_BLOCKED = 'blocked';

    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';
    public const ROLE_MODERATOR = 'moderator';


    protected static $currentUser = null;

    protected function setUserStatus($data): array
    {
        if(isset($data['data'])){

            $status = $this::STATUS_PENDING;
            #01 : Check email verification or admin approval is turn on
            if(! is_user_email_verification_enabled() &&
                ! is_user_admin_approval_enabled()){
                $status = $this::STATUS_ACTIVE;
            }

            $data['data']['status'] = $status;
        }

        return $data;
    }

    protected function hashPassword($data): array
    {
        if(isset( $data['data']['password'] )){
            $data['data']['password'] = create_hash_password( $data['data']['password'] );
        }

        return $data;
    }

    public function logged(int $userId)
    {
        $this->set('last_logged_at', Time::now()->toDateTimeString())
             ->protect(false)
             ->update($userId);
    }

    public function findUserByUsernameOrEmail( $val )
    {
        if(filter_var($val, FILTER_VALIDATE_EMAIL) !== false){
            $user = $this->findUserByEmail( $val );
        }else{
            $user = $this->findUserByUsername( $val );
        }

        return $user;
    }


    public function getUser( $id )
    {
        return $this->where('id', $id)
                    ->first();
    }

    public function findUserByUsername( $username )
    {
        return $this->where('username', $username)
                    ->first();
    }

    public function findUserByEmail( $email )
    {
        return $this->where('email', $email)
                    ->first();
    }

    public static function setCurrentUser(\App\Entities\User $user)
    {
        self::$currentUser = $user;
    }

    public static function getCurrentUser( $protected = true )
    {
        if(self::$currentUser === null && $protected){
            throw new PageNotFoundException('User not found');
        }
        return self::$currentUser;
    }

    public function emailVerified(int $userId, $verified = true): bool
    {
        $verified = (int) $verified;
        return $this->set('is_email_verified', $verified)
                    ->protect(false)
                    ->update( $userId );
    }

    public function adminApproved(int $userId, $approved = true): bool
    {
        $approved = (int) $approved;
        return $this->set('is_admin_approved', $approved)
                    ->protect(false)
                    ->update( $userId );
    }

    public function updatePassword(\App\Entities\User $user): bool
    {
        try{

            return $this->save( $user );

        }catch (\Exception $e) {}

        return false;
    }

    public function updateUserRole(int $userId, $role ): bool
    {
        try{

            return $this->set('role', $role)
                        ->protect(false)
                        ->update( $userId );

        }catch (\Exception $e) {}

        return false;
    }

    public function updateUserStatus(int $userId, $status ): bool
    {
        try{

            return $this->set('status', $status)
                        ->protect(false)
                        ->update( $userId );

        }catch (\Exception $e) {}

        return false;
    }



    public function activateAccount(int $userId): bool
    {
        return $this->updateUserStatus($userId, $this::STATUS_ACTIVE);
    }

    public function _active()
    {
        return $this->where('status', $this::STATUS_ACTIVE);
    }

    public function _pending()
    {
        return $this->where('status', $this::STATUS_PENDING);
    }


    public function _blocked(): UserModel
    {
        return $this->where('status', $this::STATUS_BLOCKED);
    }

    public function _user(): UserModel
    {
        return $this->where('role', $this::ROLE_USER);
    }

    public function _admin(): UserModel
    {
        return $this->where('role', $this::ROLE_ADMIN);
    }

    public function _moderator(): UserModel
    {
        return $this->where('role', $this::ROLE_MODERATOR);
    }





}