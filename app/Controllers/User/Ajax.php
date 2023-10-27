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

namespace App\Controllers\User;

use App\Controllers\BaseAjax;
use App\Libraries\BulkImport;
use App\Models\MovieModel;
use App\Models\SeriesModel;
use CodeIgniter\Model;

class Ajax extends BaseAjax
{

    public function get_movie(): \CodeIgniter\HTTP\Response
    {

        if($this->validate([
            'imdb' => 'required|valid_movie_id'
        ])){

            $imdbId = $this->request->getGet('imdb');
            $movieModel = new MovieModel();

            $movie = $movieModel->where('type', 'movie')
                                ->getMovieByUniqId( $imdbId );

            if($movie === null){

                // attempt to import
                if($this->importItem( $imdbId )){

                    $movie = $movieModel->where('type', 'movie')
                                        ->getMovieByUniqId( $imdbId );

                }else{

                    $this->addError( 'Movie not found' );

                }

            }

        }else{

            $this->addError( 'Invalid Imdb Id' );

        }


        if(! empty($movie)){

            $this->addData([
                'redirect_link' => site_url("user/links/add/" . encode_id( $movie->id ))
            ]);

        }

        return $this->jsonResponse();
    }

    public function get_series(): \CodeIgniter\HTTP\Response
    {

        if($this->validate([
            'imdb' => 'required|valid_movie_id'
        ])){

            $imdbId = $this->request->getGet('imdb');
            $seriesModel = new SeriesModel();

            $series = $seriesModel->getSeriesByUniqId( $imdbId );

            if($series === null){

                // attempt to import
                if($this->importItem( $imdbId, 'series' )){

                    $series = $seriesModel->getSeriesByImdbId( $imdbId );

                }else{

                    $this->addError( 'Series not found' );

                }

            }

        }else{

            $this->addError( 'Invalid Imdb Id' );

        }


        if(! empty($series)){

            $this->addData([
                'redirect_link' => site_url("user/series/view/" . encode_id( $series->id ))
            ]);

        }

        return $this->jsonResponse();
    }

    public function get_episode(): \CodeIgniter\HTTP\Response
    {

        $episode = null;
        if($this->validate([
            'imdb' => 'required|valid_movie_id',
            'sea' => 'required|is_natural_no_zero',
            'epi' => 'required|is_natural_no_zero'
        ])){

            $seriesModel = new SeriesModel();

            $imdbId = $this->request->getGet('imdb');
            $series = $seriesModel->getSeriesByUniqId( $imdbId );

            if($series !== null){

                $sea    = $this->request->getGet('sea');
                $epi    = $this->request->getGet('epi');

                $episode = model('MovieModel')->getEpisode($series->id, $sea, $epi);

                if($episode === null){

                    // attempt to import episode
                    $pattern = "{$series->imdb_id}[{$sea}.{$epi}-{$epi}]";

                    $bulkImport = new BulkImport();
                    $bulkImport->series()
                               ->set( [ $pattern ] )
                               ->run();

                    $response = $bulkImport->getResults();
                    $data = array_shift($response);
                    $data = ! empty($data['data']['episodes']) ? array_shift($data['data']['episodes']) : [];
                    if(! empty($data)){
                        $data = ! empty($data['episodes']) ? array_shift($data['episodes']) : [];
                    }

                    if(! empty($data) && $data['success'] == true){

                        // Attempt to get episode again
                        $episode = model('MovieModel')->getEpisode($series->id, $sea, $epi);

                    }else{

                        $this->addError('Episode not found');

                    }

                }

            }else{

                $this->addError('Series not found');

            }



        }else{

            $this->addError( $this->validator->getErrors() );

        }


        if(! empty($episode)){

            $this->addData([
                'redirect_link' => site_url("user/links/add/" . encode_id( $episode->id ))
            ]);

        }

        return $this->jsonResponse();


    }

    protected function importItem($uniqId , $t = 'movie'): bool
    {
        $success = false;
        $bulkImport = new BulkImport();

        $t == 'movie' ? $bulkImport->movies() : $bulkImport->series();
        $bulkImport->set( [ $uniqId ] )
                   ->run();

        $response = $bulkImport->getResults();
        if(! empty($response)){

            $data = array_shift($response);
            if($t == 'episode'){
                $data = ! empty($data['data']['episodes']) ? array_shift($data['data']['episodes']) : [];
                if(! empty($data)){
                    $data = ! empty($data['episodes']) ? array_shift($data['episodes']) : [];
                }
            }

            if(! empty($data) && $data['success'] == true){
                $success = true;
            }
        }

        return $success;
    }


}