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
 * Class ThirdPartyApi
 * @package App\Models
 * @author John Antonio
 */
class ThirdPartyApi extends Model
{
    protected $table            = 'third_party_apis';
    protected $returnType       = 'App\Entities\ThirdPartyApi';
    protected $allowedFields    = ['name', 'movie_api', 'series_api', 'status'];
    protected $useTimestamps = true;

    // Validation
    protected $validationRules      = [
        'name' => 'required|alpha_numeric_space',
        'movie_api' => 'permit_empty|valid_url',
        'series_api' => 'permit_empty|valid_url',
        'status' => 'permit_empty|in_list[active,paused]'
    ];

    protected $afterInsert = ['insertLinks'];


    public function active()
    {
        $this->where('status', 'active');
        return $this;
    }

    public function injectAll(\App\Entities\Movie $movie): array
    {
        $apis = $this->active()->findAll();
        $links = [];


        if(! empty($apis)){
            foreach ($apis as $api) {

                if($url = $this::inject($movie, $api)){

                    $links[] = [
                        'url' => $url,
                        'api_id' => $api->id
                    ];

                }

            }
        }

        return $links;
    }

    public static function inject(\App\Entities\Movie $movie, \App\Entities\ThirdPartyApi $api)
    {
        $variables = [
            'VE_MV_IMDB' => $movie->imdb_id,
            'VE_SE_IMDB' => $movie->series_imdb_id,
            'VE_MV_TMDB' => $movie->tmdb_id,
            'VE_SE_TMDB' => $movie->series_tmdb_id,
            'VE_SEASON'  => $movie->season,
            'VE_EPISODE' => $movie->episode
        ];

        $url =  ! $movie->isEpisode() ? $api->movie_api : $api->series_api;
        return var_replacement($url, $variables);
    }


    protected function insertLinks(array $data): array
    {
        if(! empty( $data['id'] )){

            $movieModel = new MovieModel();
            $movies = [];

            $tpAPI = $this->getApi( $data['id'] );
            if(! empty( $tpAPI->movie_api )){

                $movies = $movieModel->movies()
                                     ->findAll();

            }

            if(! empty( $tpAPI->series_api )){

                $episodes = $movieModel->episodes()
                                       ->findAll();

                $movies = array_merge($movies, $episodes);
            }

            if(! empty($movies)){

                foreach ($movies as $movie) {

                    if($url = ThirdPartyApi::inject($movie, $tpAPI)){

                        $data = [
                            'url' => $url,
                            'api_id' => $tpAPI->id
                        ];

                        $movieModel->addLinks($movie->id, [ $data ]);

                    }

                }

            }

        }


        return $data;
    }


    public function getApi($id)
    {
        return $this->where('id', $id)
                    ->first();
    }

}
