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
 * Class SeriesModel
 * @package App\Models
 * @author John Antonio
 */
class SeriesModel extends Model
{
    protected $table = 'series';
    protected $allowedFields = [
        'title',
        'imdb_id',
        'tmdb_id',
        'poster',
        'banner',
        'total_seasons',
        'total_episodes',
        'released_at',
        'country',
        'language',
        'imdb_rate',
        'status'
    ];
    protected $validationRules = [
        'imdb_id' => [
            'label' => 'IMDB Id',
            'rules' => 'permit_empty|is_unique[series.imdb_id]|valid_imdb_id'
        ],
        'tmdb_id' => [
            'label' => 'TMDB Id',
            'rules' => 'permit_empty|is_unique[series.tmdb_id]|valid_tmdb_id'
        ],
        'title' => 'required|min_length[1]|max_length[255]',
        'total_episodes' => 'permit_empty|is_natural',
        'total_seasons' => 'permit_empty|is_natural',
        'status' => 'required|in_list[returning,ended]'
    ];
    protected $returnType = 'App\Entities\Series';
    protected $useTimestamps = true;

    protected $afterInsert = ['importRequest', 'addCredit'];




    /**
     * Add genres to series
     * @param int $seriesId
     * @param array|null $genres
     */
    public function addGenres(int $seriesId, ?array $genres)
    {

        $seriesGenreModel = new SeriesGenreModel();
        $existGenres = $seriesGenreModel->getGenresBySeriesId( $seriesId );

        $func = function ($k, $v) {
            return [$v,$v];
        };

        if(! empty($genres))
            $genres = array_map_assoc($func, $genres);



        if(! empty($existGenres)) {

            foreach ($existGenres as $genre) {

                if(! in_array($genre->id, $genres)) {

                    $seriesGenreModel->where('series_id', $genre->series_id)
                                     ->where('genre_id', $genre->id)
                                     ->delete();

                }else{

                    $existKey = array_search($genre->id, $genres);
                    if($existKey !== false) {
                        unset($genres[$existKey]);
                    }

                }

            }

        }

        //insert new genres
        if(! empty($genres)) {
            $genreList = [];
            foreach ($genres as $genre) {
                $data = [
                    'series_id' => $seriesId,
                    'genre_id' => $genre
                ];
                $genreList[] = $data;
            }
            try{
                $seriesGenreModel->insertBatch($genreList);
            }catch (\ReflectionException $e){}
        }

    }

    protected function addCredit( $data )
    {

        if($data['result'] == true){

            if(is_logged() && ! current_user()->isAdmin()){

                // add credit
                $isAutoCredited = current_user()->isModerator();
                model('EarningsModel')->addStars( get_current_user_id(), EarningsModel::TYPE_NEW_SERIES, $isAutoCredited);

            }

        }

        return $data;
    }

    /**
     * Get series
     * @param int $id
     * @return array|object|null
     */
    public function getSeries(int $id)
    {
        return $this->where('id', $id)
                    ->first();
    }

    /**
     * Get series by imdb id
     * @param $imdbId
     * @return array|object|null
     */
    public function getSeriesByImdbId($imdbId)
    {
        return $this->where('imdb_id', $imdbId)
                    ->first();
    }

    /**
     * Get series by tmdb id
     * @param $tmdbId
     * @return array|object|null
     */
    public function getSeriesByTmdbId($tmdbId)
    {
        return $this->where('tmdb_id', $tmdbId)
                    ->first();
    }

    /**
     * Get series by imdb or tmdb id
     * @param $uniqId
     * @return array|object|null
     */
    public function getSeriesByUniqId($uniqId)
    {
        return $this->where('imdb_id', $uniqId)
                    ->orWhere('tmdb_id', $uniqId)
                    ->first();
    }

    /**
     * Get series for view
     * @param array $filters
     * @return array|object|null
     */
    public function getSeriesForView(array $filters = [])
    {

        //filter by genres
        if(! empty($filters['genreIds'])){
            $this->join('series_genre as sg', 'sg.series_id = series.id', 'LEFT');
            $this->whereIn('sg.genre_id', $filters['genreIds']);
        }

        //filter by year
        if(! empty($filters['year'])){
            $this->where('series.year', $filters['year']);
        }

        //filter by imdb rate
        if(! empty($filters['minImdbRate'])){
            $this->where('series.imdb_rate > ', $filters['minImdbRate']);
        }

        $this->select('series.*');
        $this->groupBy('series.id');
//        $this->where('series.status', 'public');

        return $this->find();
    }

    public function getCountries(): array
    {
        $results =  $this->orderBy('country', 'asc')
                         ->distinct()
                         ->select('country')
                         ->asArray()
                         ->find();

        if(! empty($results)){
            $countries = fix_arr_data( extract_array_data($results, 'country') );
        }

        return ! empty($countries) ? $countries : [];
    }


    public function getLanguages(): array
    {
        $results =  $this->orderBy('language', 'asc')
                         ->distinct()
                         ->select('language')
                         ->asArray()
                         ->find();

        if(! empty($results)){
            $languages = fix_arr_data( extract_array_data($results, 'language') );
        }
        return ! empty($languages) ? $languages : [];
    }

    public function completed($id, $isDone = true)
    {
        $isDone = (int) $isDone;
        return $this->set('is_completed', $isDone)
                    ->protect(false)
                    ->update($id);
    }


    protected function importRequest(array $data): array
    {
        if(! empty($data['id'])){

            $requestModel = new RequestsModel();
            $requestModel->itemImported( $data['data'] );

        }

        return $data;
    }

    public function getRecommendToAddLinks( $limit = 10 )
    {
        return $this->where('is_completed', 0)
                    ->limit($limit)
                    ->find();
    }




}