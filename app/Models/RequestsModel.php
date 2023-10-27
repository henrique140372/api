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
 * Class RequestsModel
 * @package App\Models
 * @author John Antonio
 */
class RequestsModel extends Model
{
    protected $table            = 'requests';
    protected $returnType       = 'App\Entities\Request';
    protected $allowedFields    = ['tmdb_id', 'title', 'type', 'status'];
    protected $useTimestamps = true;

    protected $validationRules = [
        'tmdb_id' => 'required|valid_tmdb_id|is_unique[requests.tmdb_id]',
        'title' => 'required',
        'type' => 'permit_empty|in_list[movie,tv]',
        'status' => 'permit_empty|in_list[pending,imported,canceled]'
    ];




    public function imported(): RequestsModel
    {
        $this->where('status', 'imported');
        return $this;
    }

    public function pending(): RequestsModel
    {
        $this->where('status', 'pending');
        return $this;
    }

    public function import(int $reqId ): bool
    {
         return $this->set('status', 'imported')
                     ->update($reqId);
    }

    public function unimport(int $reqId ): bool
    {
        return $this->set('status', 'pending')
                    ->update($reqId);
    }

    public function requested(int $reqId )
    {
        try{
            $this->set('requests', 'requests + 1', FALSE)
                 ->protect(false)
                 ->update( $reqId );
        }catch (\ReflectionException $e){}
    }

    public function getRequestByTmdbId( $tmdbId )
    {
        if(empty( $tmdbId )){

            return null;

        }

        return $this->where('tmdb_id', $tmdbId)
                    ->first();
    }

    public function itemImported( $itemData )
    {
        if(! empty( $itemData['tmdb_id'] )){

            $request = $this->pending()
                            ->getRequestByTmdbId( $itemData['tmdb_id'] );

            if($request !== null){
                if($this->import( $request->id )){

                    if(get_config('req_email_subscription')) {

                        //send subscription mails
                        $subscription = new RequestSubscriptionModel();
                        $subscription->sendMail( $request->id,  $itemData);

                    }

                }
            }

        }

    }

    public static function getPendingCount()
    {
        $self = new self();
        return $self->pending()
                    ->select('id')
                    ->countAllResults();
    }


}
