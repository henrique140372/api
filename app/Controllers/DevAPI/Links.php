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

namespace App\Controllers\DevAPI;


use App\Models\LinkModel;
use App\Models\MovieModel;

class Links extends BaseApi
{

    public function add()
    {

        $validationRules = [
            'imdb' => 'required|valid_imdb_id',
            'links' => 'required',
            'type' => 'required|in_list[stream,direct_dl,torrent_dl]'
        ];

        $results = [];

        if($this->validate( $validationRules )){

            $imdbId = $this->request->getGet('imdb');
            $type = $this->request->getGet('type');
            $links = str_to_array( $this->request->getGet('links') );

            //find movie
            $movieModel = new MovieModel();
            $movie = $movieModel->getMovieByImdbId( $imdbId );

            if($movie !== null){

                $linkModel = new LinkModel();

                foreach ($links as $link) {

                    $success = false;

                    $data = [
                        'movie_id' => $movie->id,
                        'link' =>  $link,
                        'type' => $type
                    ];

                    if($linkModel->insert( $data )){

                        $success = true;

                    }

                    $resp = [
                        'link' => $link,
                        'success' => $success
                    ];

                    $results[] = $resp;
                }

                $this->success();
                $this->addData( $results );

            }else{

                $this->addError( 'Movie not found' );

            }

        }else {

            $this->addError( $this->validator->getErrors() );

        }

        return $this->jsonResponse();

    }

}