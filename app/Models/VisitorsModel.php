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


use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

/**
 * Class VisitorsModel
 * @package App\Models
 * @author John Antonio
 */
class VisitorsModel extends Model
{
    protected $table = 'visitors';
    protected $returnType = 'App\Entities\Visitor';

    public const VISIT_EXPIRING_HOURS = 24;


    public function addVisit(int $movieId, $ref = null ): bool
    {
        $success = false;
        $refUserId = null;

        // Get visitor Info
        $visitorInfo = service('visitor_info');
        $ip = $visitorInfo->loadGeoData()->getIp();
        $countryCode = $visitorInfo->getCountryCode();

        if($ip === null || empty($countryCode)){
            return false;
        }

        // Get ref user
        if(! empty($ref) && $ref != current_user()->username){
            $refUser = model('UserModel')->findUserByUsername( $ref );
            if($refUser !== null && ! $refUser->isAdmin()){
                $refUserId = $refUser->id;
            }
        }

        // get Visitor
        $visitor = $this->getVisit( $movieId, $ip );
        if($this->isNewVisit( $visitor )){

            $data = [
                'movie_id'      => $movieId,
                'ip_address'    => $ip,
                'ref_user_id'   => $refUserId,
                'country_code'  => $countryCode,
                'created_at'    => Time::now()->toDateTimeString()
            ];

            try{

                $skip = false;
                if(is_views_analytics_system_enabled()){
                    if(! $this->protect(false)
                        ->insert( $data )){
                        $skip = true;
                    }
                }

                if(! $skip) {
                    // Add reward
                    if($refUserId !== null){
                        if(is_ref_rewards_system_enabled()){
                            model('EarningsModel')->addRefEarn( $refUserId,  $countryCode);
                        }
                    }
                    $success = true;
                }

            }catch (\Exception $e){}

        }else{

            if(is_views_analytics_system_enabled()){
                try{
                    if($this->set('views', 'views + 1', FALSE)
                        ->protect(false)
                        ->update($visitor->id)){
                        $success = true;
                    }
                }catch (\Exception $e){}
            }

        }

        return $success;
    }


    public function getVisit( $movieId, $ip )
    {
        return $this->where('movie_id', $movieId)
                    ->where('ip_address', $ip)
                    ->orderBy('id', 'DESC')
                    ->first();
    }

    public function isNewVisit(?\App\Entities\Visitor $visitor): bool
    {
        if($visitor !== null){

            $createdTime = $visitor->created_at;
            $expiredHours = $this::VISIT_EXPIRING_HOURS;
            $expired = strtotime($createdTime . "+{$expiredHours}hours");
            if ($expired > strtotime(Time::now()->toDateTimeString())) {

                return false;

            }

        }

        return true;
    }





}