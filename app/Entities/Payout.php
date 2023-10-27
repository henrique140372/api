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


use App\Models\PayoutsModel;

class Payout extends \CodeIgniter\Entity\Entity
{

    public function isCompleted(): bool
    {
        return $this->status == PayoutsModel::STATUS_COMPLETED;
    }

    public function isPending(): bool
    {
        return $this->status == PayoutsModel::STATUS_PENDING;
    }

    public function isRejected(): bool
    {
        return $this->status == PayoutsModel::STATUS_REJECTED;
    }


}