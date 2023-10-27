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


use CodeIgniter\Model;

/**
 * Class RefRewardsModel
 * @package App\Models
 * @author John Antonio
 */
class RefRewardsModel extends Model
{

    protected $table = 'ref_rewards';
    protected $returnType = 'App\Entities\RefReward';
    protected $allowedFields = ['name', 'stars_per_view', 'countries'];
    protected $validationRules = [
        'name'           => 'required',
        'stars_per_view' => 'required|is_natural_no_zero',
        'countries'      => 'required|valid_json'
    ];

    public static function getRewardPerViewByCountry( $country )
    {
        $self = new self;
        $reward =  $self->like('countries', $country)
                        ->first();

        if($reward !== null){

            return $reward->stars_per_view;

        }

        return get_config( 'default_ref_reward' );
    }

}