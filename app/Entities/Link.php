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


use App\Models\LinkModel;

class Link extends \CodeIgniter\Entity\Entity
{

    protected $user = null;

    public function isPending()
    {
        return $this->status == LinkModel::STATUS_PENDING;
    }

    public function isRejected()
    {
        return $this->status == LinkModel::STATUS_REJECTED;
    }

    public function isActive()
    {
        return $this->status == LinkModel::STATUS_APPROVED;
    }

    public function isBroken()
    {
        return $this->status == LinkModel::STATUS_BROKEN;
    }

    public function user()
    {
        if($this->user === null){
            $this->user = model('UserModel')->getUser( $this->user_id );
        }

        return $this->user;
    }

    public function getHost($rewrite = false)
    {
        $host = 'unknown';
        if(! empty($this->link)){
            $host = str_ireplace('www.', '', parse_url($this->link, PHP_URL_HOST));
        }

        //rewrite server names
        if($rewrite){
            $renamedServers = get_config('renamed_servers');
            if(! empty( $renamedServers[$host] )){
                $host = $renamedServers[$host];
            }
        }

        return $host;
    }


    public function getEncLink(): string
    {
        $link =  link_slug() . '/' . encode_id( $this->id );

        return site_url( $link );
    }

    public function countReports(): int
    {
        return (int) $this->reports_not_working + (int) $this->reports_wrong_link;
    }

    public function isReported(): int
    {
        return ! empty($this->reports_not_working) || ! empty($this->reports_wrong_link);
    }

    public function isApiBased(): bool
    {
        return ! empty($this->api_id);
    }


}