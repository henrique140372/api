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

namespace App\Entities;


use App\Libraries\UniqToken;
use App\Models\UserModel;

class User extends \CodeIgniter\Entity\Entity
{

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isModerator(): bool
    {
        return $this->role === 'moderator';
    }



    public function isActive(): bool
    {
        return $this->status === UserModel::STATUS_ACTIVE;
    }

    public function isPending(): bool
    {
        return $this->status === UserModel::STATUS_PENDING;
    }

    public function isBlocked(): bool
    {
        return $this->status === UserModel::STATUS_BLOCKED;
    }

    public function isEmailVerified(): bool
    {
        return $this->is_email_verified == 1;
    }

    public function isAdminApproved(): bool
    {
        return $this->is_admin_approved == 1;
    }


    public function getActiveStars(): int
    {
        $creditedStars = model('EarningsModel')->_credited()
                                                     ->getStarsByUserId( $this->id );

        $payoutStars =  model('PayoutsModel')->_completed()
                                                   ->getPayoutStarsByUserId( $this->id );

        $activeStars = 0;
        if($creditedStars > $payoutStars){
            $activeStars = $creditedStars - $payoutStars;
        }

        return $activeStars;
    }

    public function verifyPassword( $password ): bool
    {
        return password_verify($password, $this->password);
    }

    public function verifyUsername( $username ): bool
    {
        return $username == $this->username;
    }

    public function getToken(): ?string
    {
        return UniqToken::create( $this->id );
    }

    public function isFirstLogin(): bool
    {
        return empty( $this->last_logged_at );
    }

    public function is2FaLoginEnabled(): bool
    {
        return $this->is_2fa_login == 1;
    }


}