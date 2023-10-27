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
 * Class AdminModel
 * @package App\Models
 * @author John Antonio
 */
class AdminModel extends Model
{
    protected $table            = 'admin';
    protected $returnType       = 'App\Entities\Admin';
    protected $allowedFields    = ['display_name', 'username', 'password'];

    // Dates
    protected $useTimestamps = false;


    //callbacks
    protected $beforeUpdate = ['hashPassword'];

    /**
     * Hash password before update admin password
     * @param array $data
     * @return array
     */
    protected function hashPassword(array $data): array
    {
        if(isset( $data['data']['password'] )){
            $data['data']['password'] = password_hash( $data['data']['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }

    /**
     * Get admin
     * @return array|object|null
     */
    public function getAdmin()
    {
        return $this->where('id', 1)
                    ->first();
    }

}
