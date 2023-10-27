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
use CodeIgniter\Model;

/**
 * Class PayoutsModel
 * @package App\Models
 * @author John Antonio
 */
class PayoutsModel extends Model
{
    protected $table = 'payouts';
    protected $returnType = 'App\Entities\Payout';
    protected $allowedFields = ['user_id', 'stars', 'payment_method', 'account_details',  'status'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'user_id' => 'required|is_natural_no_zero|exist[users.id]',
        'stars'  => 'required|is_natural_no_zero',
        'payment_method'  => 'required|valid_payment_method',
        'account_details'  => 'required',
        'status'  => 'permit_empty|in_list[pending,completed,rejected]'
    ];

    protected $beforeInsert = ['setStatus', 'setMoneyBalance'];

    public const STATUS_COMPLETED = 'completed';
    public const STATUS_PENDING = 'pending';
    public const STATUS_REJECTED = 'rejected';


    protected function setStatus($data): array
    {
        if(isset($data['data'])){
            $data['data']['status'] = $this::STATUS_PENDING;
        }

        return $data;
    }

    protected function setMoneyBalance($data): array
    {
        if(isset($data['data'])){
            $data['data']['money_balance'] = stars_exchange( $data['data']['stars'] );
        }

        return $data;
    }

    public function getPayoutStarsByUserId(int $userId): int
    {
        return (int) $this->_user( $userId )
                          ->selectSum('stars')
                          ->first()
                          ->stars;
    }

    public function hasPendingPayoutRequestByUserId(int $userId): bool
    {
        $results = $this->_pending()
                        ->getPayoutRequestsByUserId( $userId, 1 );

        return ! empty( $results );
    }

    public function getPayoutRequestsByUserId(int $userId, int $limit = 0): array
    {
        return $this->_user( $userId )
                    ->findAll( $limit );
    }

    public function getPendingRequestByUserId(int $userId)
    {
        $pendingPayout = $this->_pending()
                             ->getPayoutRequestsByUserId($userId, 1);
        return ! empty($pendingPayout) ? $pendingPayout[0] : null;
    }
    public function _completed(): PayoutsModel
    {
        return $this->where('status', $this::STATUS_COMPLETED);
    }

    public function _pending(): PayoutsModel
    {
        return $this->where('status', $this::STATUS_PENDING);
    }

    public function _rejected(): PayoutsModel
    {
        return $this->where('status', $this::STATUS_REJECTED);
    }

    public function _user( $uId ): PayoutsModel
    {
        return $this->where('user_id', $uId);
    }

}