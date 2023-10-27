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
 * Class SeriesGenreModel
 * @package App\Models
 * @author John Antonio
 */
class SeriesGenreModel extends Model
{
    protected $table = 'series_genre';
    protected $allowedFields = [ 'series_id', 'genre_id' ];
    protected $validationRules = [
        'series_id' => 'required|is_natural_no_zero|exist[series.id]',
        'genre_id' => 'required|is_natural_no_zero|exist[genres.id]'
    ];
    protected $returnType = 'App\Entities\Genre';

    /**
     * Get genres by series id
     * @param int|null $seriesId
     * @return array|null
     */
    public function getGenresBySeriesId(?int $seriesId): ?array
    {
        if(empty($seriesId))
            return null;

        $genres = [];

        $results = $this->join('genres', 'genres.id = series_genre.genre_id', 'LEFT')
                        ->where('series_id', $seriesId)
                        ->select('series_genre.series_id, series_genre.genre_id as id, genres.name')
                        ->findAll();

        if(! empty($results)){
            foreach ($results as $result) {
                $genres[$result->id] = $result;
            }
        }
        return $genres;
    }

}