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
 * Class LinkModel
 * @package App\Models
 * @author John Antonio
 */
class LinkModel extends Model
{
    protected $table = 'links';
    protected $allowedFields = [ 'movie_id', 'api_id','link', 'resolution', 'quality','size_val', 'size_lbl', 'type' ];
    protected $validationRules = [
        'movie_id' => 'required|is_natural_no_zero|exist[movies.id]',
        'api_id' => 'permit_empty|is_natural_no_zero|exist[third_party_apis.id]',
        'link' => 'required|valid_url',
        'type' => 'permit_empty|in_list[stream,direct_dl,torrent_dl]',
        'size_val' => 'permit_empty|numeric',
        'size_lbl' => 'permit_empty|in_list[MB,GB]',
        'status'   => 'permit_empty|in_list[active,rejected,pending,broken]'
    ];
    protected $returnType = 'App\Entities\Link';
    protected $useTimestamps = true;

    protected $beforeInsert = ['setUserId'];
    protected $afterInsert = ['addCredit'];
    protected $beforeDelete = ['removeCredit'];


    public const TYPE_STREAM = 'stream';
    public const TYPE_DIRECT_DL = 'direct_dl';
    public const TYPE_TORRENT_DL = 'torrent_dl';

    public const STATUS_APPROVED = 'active';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_PENDING = 'pending';
    public const STATUS_BROKEN = 'broken';


    protected function setUserId( $data )
    {
        $data = $data['data'];

        if( is_logged() ){
            if(! current_user()->isAdmin() && empty($data['api_id'])){
                $data['user_id'] = get_current_user_id();
            }

            if( current_user()->isUser() ){
                $data['status'] = $this::STATUS_PENDING;
            }

        }

        return [ 'data' => $data];
    }

    public function approved(\App\Entities\Link $link): bool
    {
        if( $this->protect(false)
                 ->update($link->id, [ 'status' => $this::STATUS_APPROVED ]) ){

            //release credit
            model('EarningsModel')->updateCreditStatus($link, true);

            return true;
        }

        return false;
    }

    public function rejected(\App\Entities\Link $link): bool
    {
        if( $this->protect(false)
                 ->update($link->id, [ 'status' => $this::STATUS_REJECTED ]) ){

            //release credit
            model('EarningsModel')->updateCreditStatus($link, false);

            return true;
        }

        return false;
    }

    protected function addCredit( $data )
    {

        if($data['result'] == true){

            if(is_logged() && ! current_user()->isAdmin()){

                $earningsModel = new EarningsModel();

                $movie = model('MovieModel')->getMovie( $data['data']['movie_id'] );
                $type = $earningsModel->getType($data['data']['type'], ! $movie->isEpisode());

                // add credit
                $isAutoCredited = current_user()->isModerator();
                $earningsModel->addStars( get_current_user_id(), $type,  $isAutoCredited);

            }

        }

        return $data;
    }

    protected function removeCredit( $data )
    {
        if(isset($data['id'][0])){
            $id = $data['id'][0];
            $link = $this->getLink( $id );
            if($link !== null){
                if($link->isPending()){

                    $movie = model('MovieModel')->getMovie( $link->movie_id );
                    $earningsModel = new EarningsModel();

                    $type = $earningsModel->getType($link->type, ! $movie->isEpisode());
                    $earnings = $earningsModel->_user( $link->user_id )
                                              ->_pending()
                                              ->where('type', $type)
                                              ->orderBy('id', 'DESC')
                                              ->first();

                    //attempt to remove credit
                    if($earnings !== null){
                        $earningsModel->delete( $earnings->id );
                    }

                }
            }
        }

        return $data;
    }

    /**
     * Find links by movie (or episode) id
     * @param int $movieId
     * @param string|null $type stream, direct_download, torrent_download
     * @param bool $withBroken
     * @return array|object|null
     */
    public function findByMovieId(int $movieId, ?string $type = null, bool $withBroken = true)
    {
        if(empty( $movieId ))
            return null;

        if(! empty($type)) {
            $this->where('type', $type);
        }

        if(! $withBroken){
            $this->where('is_broken', 0);
        }

        $this->orderBy('api_id', 'desc');
        return $this->where('movie_id', $movieId)
                    ->find();
    }

    public function forView()
    {
        $this->where('status', $this::STATUS_APPROVED);
        return $this;
    }

    /**
     * Clean empty links by movie id and links ids
     * @param int $movieId
     * @param array $skipIds
     */
    public function clean(int $movieId, array $skipIds = [])
    {
        if(!empty( $skipIds )) {
            $this->whereNotIn('id', $skipIds);
        }
        $this->where('movie_id', $movieId)
             ->delete();
    }

    /**
     * Update link requests
     * @param $linkId
     */
    public function updateRequests( $linkId )
    {
        try{
            $this->set('requests', 'requests + 1', FALSE)
                 ->protect(false)
                 ->update($linkId);
        }catch (\ReflectionException $e) {}
    }

    /**
     * report link
     * @param int $linkId
     * @param bool $notWorking
     */
    public function report(int $linkId, bool $notWorking = true )
    {
        try{

            if($notWorking){
                $this->set('reports_not_working', 'reports_not_working + 1', FALSE);
            }else{
                $this->set('reports_wrong_link', 'reports_wrong_link + 1', FALSE);
            }

            $this->protect(false)
                 ->update( $linkId );

        }catch (\ReflectionException $e) {}
    }

    /**
     * Reset link reports
     * @param int $linkId
     * @return bool
     */
    public function resetReports(int $linkId ): bool
    {
        try{
            return $this->set('reports_not_working', 0)
                        ->set('reports_wrong_link', 0)
                        ->protect(false)
                        ->update( $linkId );
        }catch (\ReflectionException $e) {}
        return false;
    }

    /**
     * Select broken links
     * @param bool $st
     * @return $this
     */
    public function broken(bool $st = true): LinkModel
    {
        $st = (int) $st;
        $this->where('is_broken', $st);
        return $this;
    }



    /**
     * Link reported
     * @return $this
     */
    public function reported(): LinkModel
    {
        $this->where('reports_wrong_link > ', 0);
        $this->orWhere('reports_not_working > ', 0);
        return $this;
    }

    /**
     * Get link by ID
     * @param int $id
     * @return array|object|null
     */
    public function getLink(int $id )
    {
        return $this->where('id', $id)
                    ->first();
    }

    public function movies()
    {
        $this->join('movies', 'movies.id = links.movie_id', 'LEFT')
             ->where('movies.type', 'movie');

        return $this;
    }

    public function episodes()
    {
        $this->join('movies', 'movies.id = links.movie_id', 'LEFT')
             ->where('movies.type', 'episode');

        return $this;
    }

    public function _user( $uId ): LinkModel
    {
        return $this->where('user_id', $uId);
    }

    public function _movie( $mId ): LinkModel
    {
        return $this->where('movie_id', $mId);
    }

    public function _pending( ): LinkModel
    {
        return $this->where('status', $this::STATUS_PENDING);
    }

    public static function isValidType( $t ): bool
    {
        return in_array($t, [self::TYPE_STREAM, self::TYPE_DIRECT_DL, self::TYPE_TORRENT_DL]);
    }

    public static function isValidStatus( $s ): bool
    {
        return in_array($s, [self::STATUS_APPROVED, self::STATUS_PENDING, self::STATUS_REJECTED, self::STATUS_BROKEN]);
    }

}