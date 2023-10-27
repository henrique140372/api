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
 * Class MovieGenreModel
 * @package App\Models
 * @author John Antonio
 */
class MovieGenreModel extends Model
{
    protected $table = 'movie_genre';
    protected $allowedFields = [ 'movie_id', 'genre_id' ];
    protected $validationRules = [
        'movie_id' => 'required|is_natural_no_zero|exist[movies.id]',
        'genre_id' => 'required|is_natural_no_zero|exist[genres.id]'
    ];
    protected $returnType = 'App\Entities\Genre';


    /**
     * Get all genres by movie id
     * @param int|null $movieId
     * @return array|null
     */
    public function getGenresByMovieId(?int $movieId ): ?array
    {
        if(empty($movieId))
            return null;

        $genres = [];

        $results = $this->join('genres', 'genres.id = movie_genre.genre_id', 'LEFT')
                        ->where('movie_id', $movieId)
                        ->select('movie_genre.movie_id, movie_genre.genre_id as id, genres.name')
                        ->findAll();

        if(! empty($results)){
            foreach ($results as $result) {
                $genres[$result->id] = $result;
            }
        }
        return $genres;
    }

    /**
     * Find by movie id
     * @param int $movie_id
     * @return array
     */
    public function findByMovieId(int $movie_id): array
    {
        if(empty($movie_id))
            return [];

        return $this->where('movie_id', $movie_id)
                    ->findAll();

    }

}