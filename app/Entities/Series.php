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


use App\Models\SeriesGenreModel;
use CodeIgniter\Model;

class Series extends \CodeIgniter\Entity\Entity
{

    protected $genres = null;


    public function getMovieTitle() {

        $title = $this->title;
        if(! empty($this->year)){
            $title .= ' - ' . $this->year;
        }
        return $title;

    }

    public function getReleasedYear()
    {
        if(empty($this->released_at))
            return '';

        return date('Y', strtotime($this->released_at));
    }

    public function getDefaultEmbedLink(): string
    {
        $slug = '';
        switch ( get_default_movies_permalink_type() ) {
            case 'imdb_short':
                $slug =  ! empty($this->imdb_id) ? "/{$this->imdb_id}" : '';
                break;
            case 'imdb_long':
                $slug =  ! empty($this->imdb_id) ? "/series?imdb={$this->imdb_id}" : '';
                break;
            case 'tmdb_short':
                $slug =  ! empty($this->tmdb_id) ? "/{$this->tmdb_id}" : '';
                break;
            case 'tmdb_long':
                $slug =  ! empty($this->tmdb_id) ? "/series?tmdb={$this->tmdb_id}" : '';
                break;
            case 'general_id_short':
                $slug =  "/" . encode_id( $this->id );
                break;
            case 'general_id_long':
                $slug = "/series?id=" . encode_id( $this->id );
                break;
            case 'custom_dynamic':
                $slug = '/' . create_custom_movie_slug( $this );
                break;
        }

        if(empty($slug)){
            $slug = '/series?id=' . encode_id( $this->id );
        }

        return site_url( "/" . embed_slug() .  "{$slug}" );
    }

    public function getEmbedLink($short = false)
    {
        $slugType = get_config('default_embed_slug_type');
        if($slugType == 'imdb'){
            if(! empty($this->imdb_id)){
                $link = $short ? "/{$this->imdb_id}" : "/series?imdb={$this->imdb_id}";
            }
        }elseif($slugType == 'tmdb'){
            if(! empty($this->tmdb_id)){
                $link = $short ? "/{$this->tmdb_id}" : "/series?tmdb={$this->tmdb_id}";
            }
        }

        if(empty($link)) {
            $encId = encode_id( $this->id );
            $link = $short ? "/{$encId}" : "/series?id={$encId}";
        }

        return site_url( "/" . embed_slug() . "{$link}" );
    }

    public function getDownloadLink()
    {
        $link = $this->getDefaultEmbedLink();
        return str_replace('/'.embed_slug().'/', '/'.download_slug().'/', $link);
    }

    public function getViewLink()
    {
        $viewLink = $this->getDefaultEmbedLink();
        return str_replace('/'.embed_slug().'/' ,'/'.view_slug().'/', $viewLink);
    }

    public function genres()
    {
        if($this->genres === null){

            $seriesGenreModel = new SeriesGenreModel();
            $this->genres = [];

            $genres = $seriesGenreModel->getGenresBySeriesId( $this->id );

            if($genres !== null){
                $this->genres = $genres;
            }

            unset($seriesGenreModel);

        }

        return  $this->genres;
    }

    public function addPoster($posterFile)
    {
        $this->posterRemoved();
        $posterName = $posterFile->getRandomName();
        $posterFile->move( poster_dir(), $posterName );
        $this->poster = $posterName;
    }

    public function addBanner($bannerFile)
    {
        $this->bannerRemoved();
        $bannerName = $bannerFile->getRandomName();
        $bannerFile->move( banner_dir(), $bannerName );
        $this->banner = $bannerName;
    }


    public function posterRemoved()
    {
        if(! empty($this->poster)){
            delete_poster( $this->poster );
        }
        $this->poster = null;
    }

    public function bannerRemoved()
    {
        if(! empty($this->banner)){
            delete_banner( $this->banner );
        }
        $this->banner = null;
    }

    public function hasPoster()
    {
        return !empty($this->poster);
    }

    public function hasBanner()
    {
        return !empty($this->banner);
    }



}