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
 * Class FailedMovies
 * @package App\Models
 * @author John Antonio
 */
class FailedMovies extends Model
{
    protected $table            = 'failed_movies';
    protected $allowedFields = ['title', 'imdb_id', 'tmdb_id',  'type'];

    // Dates
    protected $useTimestamps = true;

    // Validation
    protected $validationRules      = [
        'imdb_id' => 'required|is_unique[movies.imdb_id,failed_movies.imdb_id]|valid_imdb_id',
        'tmdb_id' => 'permit_empty|is_unique[movies.tmdb_id,failed_movies.tmdb_id]|valid_tmdb_id',
        'type'    => 'permit_empty|in_list[movie,episode,series]',
        'title'   => 'permit_empty|min_length[5]|max_length[255]'
    ];


    /**
     * Find failed movie by imdb or tmdb id
     * @param $reqId
     * @return array|object|null
     */
    public function findByReqId( $reqId )
    {
        return $this->where('tmdb_id', $reqId)
                    ->orWhere('imdb_id', $reqId)
                    ->first();
    }

    /**
     * Update requests in the link
     * @param $failedMovieId
     */
    public function updateRequests( $failedMovieId )
    {
        try{
            $this->set('requests', 'requests + 1', FALSE)
                ->protect(false)
                ->update( $failedMovieId );
        }catch (\ReflectionException $e){}
    }

    public static function getPendingCount()
    {
        $self = new self();
        return $self->select('id')
                    ->countAllResults();
    }

}
