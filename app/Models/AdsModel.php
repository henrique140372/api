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
 * Class AdsModel
 * @package App\Models
 * @author John Antonio
 */
class AdsModel extends Model
{
    protected $table            = 'ads';
    protected $returnType       = 'App\Entities\Ad';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['ad_code', 'status'];

    // Validation
    protected $validationRules      = [
        'status' => 'in_list[active,paused]'
    ];
    protected $validationMessages   = [];

    protected $afterFind = ['changeArrayKey'];

    /**
     * Set ads identity key to as results key after find data
     * @param array $data
     * @return array
     */
    protected function changeArrayKey(array $data): array
    {
        if($data['method'] != 'first'){

            if(is_array($data['data'])){

                foreach ($data['data'] as $key => $val) {
                    $newKey = "{$val->page}.{$val->type}";
                    if($val->type != 'popad'){
                        $newKey .= ".{$val->position}";
                    }
                    unset($data['data'][$key]);

                    $data['data'][$newKey] = $val;

                }

            }

        }

        return $data;

    }

    /**
     * Get ads for public view
     * @return $this
     */
    public function forView(): AdsModel
    {
        $this->where('status', 'active');
        return $this;
    }

    /**
     * Get all ads
     * @param null $page
     * @return array
     */
    public function getAds( $page = null ): array
    {
        return $this->where('page', $page)
                    ->findAll();
    }

}
