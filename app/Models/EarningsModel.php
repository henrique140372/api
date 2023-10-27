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

use App\Entities\Earnings;
use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

/**
 * Class EarningsModel
 * @package App\Models
 * @author John Antonio
 */
class EarningsModel extends Model
{
    protected $table = 'earnings';
    protected $returnType = 'App\Entities\Earnings';

    protected $earnStructure = null;
    protected $useTimestamps = true;


    public const TYPE_MOVIE_STREAM_LINK = 'movie_stream_link';
    public const TYPE_MOVIE_DIRECT_LINK = 'movie_direct_link';
    public const TYPE_MOVIE_TORRENT_LINK = 'movie_torrent_link';
    public const TYPE_EPISODE_STREAM_LINK = 'episode_stream_link';
    public const TYPE_EPISODE_DIRECT_LINK = 'episode_direct_link';
    public const TYPE_EPISODE_TORRENT_LINK = 'episode_torrent_link';
    public const TYPE_NEW_MOVIE = 'new_movie';
    public const TYPE_NEW_SERIES = 'new_series';
    public const TYPE_NEW_EPISODE = 'new_episode';
    public const TYPE_REF_EARN = 'referrals';

    public const STATUS_CREDITED = 'credited';
    public const STATUS_PENDING = 'pending';
    public const STATUS_REJECTED = 'rejected';


    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function addStars($userId, $type, $isAutoCredited = false): bool
    {
        if(! array_key_exists($type, $this->earnStructure)){

            return false;

        }

        $status =  $this->isAutoCredited( $type ) || $isAutoCredited ? $this::STATUS_CREDITED : $this::STATUS_PENDING;

        // Attempt to add stars
        $data = [
            'user_id' => $userId,
            'type'    => $type,
            'stars'   => $this->getStarts( $type ),
            'status'  => $status
        ];

        return $this->protect(false)
                    ->insert( $data );
    }

    public function updateCreditStatus(\App\Entities\Link $link, $isApproved = false, $type = null)
    {
        if($link->isActive()){
            $status = $this::STATUS_CREDITED;
        }else if($link->isRejected()){
            $status = $this::STATUS_REJECTED;
        }else{
            $status = $this::STATUS_PENDING;
        }

        if($type == null){
            $movie = model('MovieModel')->getMovie( $link->movie_id );
            $type = $this->getType($link->type, ! $movie->isEpisode());
        }

        $earnings = $this->_user( $link->user_id )
                         ->where('status', $status)
                         ->where('type', $type)
                         ->first();

        if($earnings !== null){

            $status = $isApproved ? $this::STATUS_CREDITED : $this::STATUS_REJECTED;
            $earnings->status = $status;
            if($earnings->hasChanged('status')){
                return $this->protect(false)
                            ->save( $earnings );
            }

        }


        return false;

    }

    public function getStarts( $type )
    {
        return $this->earnStructure[$type]['stars'] ?? 0;
    }

    public function isAutoCredited( $type )
    {
        return $this->earnStructure[$type]['is_auto_credited'] ?? false;
    }


    public function _user( $uId ): EarningsModel
    {
        return $this->where('user_id', $uId);
    }

    public function _credited(): EarningsModel
    {
        return $this->where('status', $this::STATUS_CREDITED);
    }
    public function _pending(): EarningsModel
    {
        return $this->where('status', $this::STATUS_PENDING);
    }
    public function _rejected(): EarningsModel
    {
        return $this->where('status', $this::STATUS_REJECTED);
    }

    public function getStarsByUserId(int $userId): int
    {
        return (int) $this->_user( $userId )
                          ->selectSum('stars')
                          ->first()
                          ->stars;
    }

    public function removePendingStarsByLink(\App\Entities\Link $link): bool
    {
        if($link->isPending()){

            $movie = model('MovieModel')->getMovie( $link->movie_id );
            $type = $this->getType($link->type, ! $movie->isEpisode());

            $earnings = $this->_user( $link->user_id )
                             ->_pending()
                             ->where('type', $type)
                             ->orderBy('id', 'DESC')
                             ->first();

            //attempt to remove credit
            if($earnings !== null){
                $this->delete( $earnings->id );
                return true;
            }

        }

        return false;
    }

    public function removePendingStarsByMovie(\App\Entities\Movie $movie)
    {
        $pendingLinks = model('LinkModel')->_movie( $movie->id )
                                          ->_pending()
                                          ->find();

        if(! empty($pendingLinks)){

            foreach ($pendingLinks as $link) {
                $this->removePendingStarsByLink( $link );
            }

        }


    }

    public function getType($linkType, $isMovie = true ): string
    {
        $type = '';

        switch ($linkType) {
            case LinkModel::TYPE_STREAM:
                $type = $isMovie ? $this::TYPE_MOVIE_STREAM_LINK : $this::TYPE_EPISODE_STREAM_LINK;
                break;
            case LinkModel::TYPE_DIRECT_DL:
                $type = $isMovie ? $this::TYPE_MOVIE_DIRECT_LINK : $this::TYPE_EPISODE_DIRECT_LINK;
                break;
            case LinkModel::TYPE_TORRENT_DL:
                $type = $isMovie ? $this::TYPE_MOVIE_TORRENT_LINK : $this::TYPE_EPISODE_TORRENT_LINK;
                break;
        }

        if(empty($type))
            dd('INVALID LINK TYPE');

        return $type;
    }

    public function addRefEarn(int $user_id, $country )
    {
        $earn = $this->_user( $user_id )
                     ->where('type', $this::TYPE_REF_EARN)
                     ->first();

        if($earn === null){
            $earn = new Earnings([
                'user_id' => $user_id,
                'type'    => $this::TYPE_REF_EARN,
                'stars'   => 0,
                'status'  => $this::STATUS_CREDITED
            ]);
        }

        $reward = RefRewardsModel::getRewardPerViewByCountry( $country );
        $earn->stars =  $earn->stars + $reward;

        if($earn->hasChanged('stars')){
            try{
                $this->protect(false)->save( $earn );
            }catch(\Exception $e){ }
        }

    }

    protected function init()
    {
        // init earning structure
        $this->earnStructure = [

            $this::TYPE_NEW_MOVIE => [
                'stars'             => get_stars_by_earning_type( $this::TYPE_NEW_MOVIE ),
                'is_auto_credited'  => true,
                'description'       => lang('EarnMoney.adding_new_movie')
            ],
            $this::TYPE_MOVIE_STREAM_LINK   => [
                'stars'             => get_stars_by_earning_type( $this::TYPE_MOVIE_STREAM_LINK ),
                'is_auto_credited'  => false,
                'description'       => lang('EarnMoney.adding_stream_link_to_movie')
            ],
            $this::TYPE_MOVIE_DIRECT_LINK   => [
                'stars'             => get_stars_by_earning_type( $this::TYPE_MOVIE_DIRECT_LINK ),
                'is_auto_credited'  => false,
                'description'       => lang('EarnMoney.adding_direct_dl_link_to_movie')
            ],
            $this::TYPE_MOVIE_TORRENT_LINK   => [
                'stars'             => get_stars_by_earning_type( $this::TYPE_MOVIE_TORRENT_LINK ),
                'is_auto_credited'  => false,
                'description'       => lang('EarnMoney.adding_torrent_dl_link_to_movie')
            ],
            $this::TYPE_NEW_SERIES => [
                'stars'             => get_stars_by_earning_type( $this::TYPE_NEW_SERIES ),
                'is_auto_credited'  => true,
                'description'       => lang('EarnMoney.adding_new_series')
            ],
            $this::TYPE_NEW_EPISODE => [
                'stars'             => get_stars_by_earning_type( $this::TYPE_NEW_EPISODE ),
                'is_auto_credited'  => true,
                'description'       => lang('EarnMoney.adding_new_episode')
            ],
            $this::TYPE_EPISODE_STREAM_LINK => [
                'stars'             => get_stars_by_earning_type( $this::TYPE_EPISODE_STREAM_LINK ),
                'is_auto_credited'  => false,
                'description'       => lang('EarnMoney.adding_stream_link_to_episode')
            ],
            $this::TYPE_EPISODE_DIRECT_LINK => [
                'stars'             => get_stars_by_earning_type( $this::TYPE_EPISODE_DIRECT_LINK ),
                'is_auto_credited'  => false,
                'description'       => lang('EarnMoney.adding_direct_dl_link_to_episode')
            ],
            $this::TYPE_EPISODE_TORRENT_LINK => [
                'stars'             => get_stars_by_earning_type( $this::TYPE_EPISODE_TORRENT_LINK ),
                'is_auto_credited'  => false,
                'description'       => lang('EarnMoney.adding_torrent_dl_link_to_episode')
            ]

        ];
    }

    public function getEarnStructure()
    {
        return $this->earnStructure;
    }

    public static function isRewardTypeEnabled($type): bool
    {
        $self = new self;
        return ! empty($self->getStarts( $type ));
    }

    public static function getEarningsTypes(): array
    {
        $self = new self;
        $types = array_keys($self->earnStructure);
        array_unshift($types, $self::TYPE_REF_EARN);
        return $types;
    }

}