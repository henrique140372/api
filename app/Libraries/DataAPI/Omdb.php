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

namespace App\Libraries\DataAPI;


use App\Libraries\DataAPI\Items\Episode;
use App\Libraries\DataAPI\Items\Item;
use App\Libraries\DataAPI\Items\Movie;
use App\Libraries\DataAPI\Items\Series;

class Omdb
{

    protected $apiKey;
    protected $baseUrl = 'https://www.omdbapi.com';
    protected $httpClient;

    public function __construct()
    {
        $options = [
            'timeout' => 5,
            'http_errors' => false
        ];
        $this->httpClient = \Config\Services::curlrequest($options);
        $this->apiKey = get_config('omdb_api_key');
    }

    public function getMovie($imdbId)
    {
        return $this->findByImdbId( $imdbId, 'movie' );
    }

    public function getTv($imdbId)
    {
        return $this->findByImdbId( $imdbId, 'series' );
    }

    public function getEpisode($imdbId, $season = null, $episode = null)
    {
        if(! empty($season)){
            $options = [
                'i' => $imdbId,
                'season' => $season,
                'episode' => $episode
            ];
            $results = $this->getData( $options );

            if($results !== null){

                return $this->cleanResults( $results );

            }

        }
        return $this->findByImdbId( $imdbId, 'episode' );
    }

    public function findByImdbId($imdbId, $type = null)
    {
        $results = $this->getData( [
            'i' => $imdbId ,
            'type' => $type
        ] );

        if($results !== null){

            $results = $this->cleanResults( $results );;

            if(empty($results) || ! empty($type) && $results->type != $type){
                return null;
            }

            return $results;

        }

        return null;


    }

    protected function cleanResults( $results )
    {
        $type = $results['Type'] ?? '';

        switch ($type) {
            case 'series':

                $series = new Series( 'omdb', $results );
                $series->cleanData();

                return $series;

                break;
            case 'movie':

                $movie = new Movie( 'omdb', $results );
                $movie->cleanData();

                return $movie;

                break;
            case 'episode':

                $episode = new Episode( 'omdb', $results );
                $episode->cleanData();

                return $episode;

                break;
        }

        return null;
    }


    protected function getData($options = [])
    {
        $url = "{$this->baseUrl}/";

        $options['apikey'] = $this->apiKey;

        $response = $this->httpClient->request('get', $url, [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'query' => $options
        ]);

        if ($response->getStatusCode() == 200) {
            if (strpos($response->getHeader('content-type'), 'application/json') !== false) {
                return json_decode($response->getBody(), true);
            }
        }

        return null;
    }


}