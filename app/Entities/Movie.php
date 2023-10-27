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


use App\Models\GenreModel;
use App\Models\MovieGenreModel;
use App\Models\SeasonModel;
use CodeIgniter\Entity\Entity;
use CodeIgniter\Model;

class Movie extends \CodeIgniter\Entity\Entity
{


    protected $tmpLinks = [];
    protected $tmpCategories;

    protected $seasonObj = null;
    protected $genres = null;

    public function getMovieTitle() {

        $title = $this->title;

        if( $this->isEpisode() ){

            if(! empty($this->season) && ! empty($this->series_title)) {

                $sea = sprintf("%02d", $this->season);
                $epi = sprintf("%02d", $this->episode);

                $title =  "{$this->series_title} [S{$sea}E{$epi}] - $this->title";

            }

        }else{
            if(! empty( $this->year )){
                $title .= ' - ' . $this->year;
            }
        }



        return $title;

    }

    public function getReleasedYear()
    {
        if(empty($this->released_at))
            return '';

        return date('Y', strtotime($this->released_at));
    }

    public function getMovieTrailer()
    {
        if(! empty( $this->trailer )){
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $this->trailer, $match);
            if(isset( $match[1] )){

                return "https://www.youtube.com/embed/{$match[1]}";

            }
        }

        return  $this->trailer;
    }

    public function getMovieCountries(): array
    {
        $countries = ! $this->isEpisode() ? $this->country : $this->series_country;
        if(! empty($countries)){
            $countries = fix_arr_data( [ $countries ] ) ;
            if(! empty($countries) && is_array( $countries )){
                return $countries;
            }
        }

        return [];
    }

    public function getMovieLanguages(): array
    {
        $languages = ! $this->isEpisode() ? $this->language : $this->series_language;
        if(! empty($languages)){
            $languages = fix_arr_data( [ $languages ] ) ;
            if(! empty($languages) && is_array( $languages )){
                return $languages;
            }
        }
        return [];
    }

    public function getMovieImdbRate()
    {
        if(! empty( $this->imdb_rate ) && $this->imdb_rate != '0.0') {
            return $this->imdb_rate;
        }
        return  'N/A';
    }

    public function getDefaultEmbedLink(): string
    {
        $slug = '';
        switch ( get_default_movies_permalink_type() ) {
            case 'imdb_short':
                    $slug =  ! empty($this->imdb_id) ? "/{$this->imdb_id}" : '';
                break;
            case 'imdb_long':
                    $slug =  ! empty($this->imdb_id) ? "/movie?imdb={$this->imdb_id}" : '';
                break;
            case 'tmdb_short':
                    $slug =  ! empty($this->tmdb_id) ? "/{$this->tmdb_id}" : '';
                break;
            case 'tmdb_long':
                    $slug =  ! empty($this->tmdb_id) ? "/movie?tmdb={$this->tmdb_id}" : '';
                break;
            case 'general_id_short':
                    $slug =  "/" . encode_id( $this->id );
                break;
            case 'general_id_long':
                    $slug = "/movie?id=" . encode_id( $this->id );
                break;
            case 'custom_dynamic':
                    $slug = '/' . create_custom_movie_slug( $this );
                break;
        }

        if(empty($slug)){
            $slug = '/movie?id=' . encode_id( $this->id );
        }

        return site_url( "/" . embed_slug() .  "{$slug}" );
    }


    public function getEmbedLink($short = false): string
    {
        $link = null;
        $slugType = get_config('default_embed_slug_type');


        if(! $this->isEpisode()){

            if($slugType == 'imdb'){
                if(! empty($this->imdb_id)){
                    $link = $short ? "/{$this->imdb_id}" : "/movie?imdb={$this->imdb_id}";
                }
            }elseif($slugType == 'tmdb'){
                if(! empty($this->tmdb_id)){
                    $link = $short ? "/{$this->tmdb_id}" : "/movie?tmdb={$this->tmdb_id}";
                }
            }

            //default
            if($link === null) {
                $encId = encode_id( $this->id );
                $link = $short ? "/{$encId}" : "/movie?id={$encId}";
            }

        }else{

            $season = $this->season ?? $this->season()->season;
            $episode = $this->episode ?? 1;

            if($slugType == 'imdb'){
                if(! empty($this->imdb_id)){
                    $link = $short ? "/{$this->imdb_id}" : "/series?imdb={$this->imdb_id}&sea={$season}&epi={$episode}";
                }
            }elseif($slugType == 'tmdb'){
                if(! empty($this->tmdb_id)){
                    $link = $short ? "/{$this->tmdb_id}" : "/series?tmdb={$this->tmdb_id}&sea={$season}&epi={$episode}";
                }
            }

            //default
            if($link === null){
                $encId = encode_id( $this->id );
                $link = $short ? "/{$encId}" : "/series?id={$encId}&sea={$season}&epi={$episode}";
            }

        }


        $url = site_url("/" . embed_slug() .  "{$link}" );
        if(is_logged() && ! is_admin()){
            $ref = current_user()->username;
            $query = parse_url($url, PHP_URL_QUERY);
            $url .= $query ? '&ref=' . $ref : '?ref=' . $ref;
        }

        return $url;
    }

    public function getUniqueId()
    {
        $isMovie = empty($this->series_id) ? 'movie' : 'series';
        return get_movie_id_data($this, 'id', $isMovie);
    }

    public function getUniqueIdType()
    {
        $isMovie = empty($this->series_id) ? 'movie' : 'series';
        return get_movie_id_data($this, 'type', $isMovie);
    }

    public function getDownloadLink()
    {
        $link = $this->getDefaultEmbedLink();
        return str_replace('/'.embed_slug().'/', '/'.download_slug().'/', $link);
    }


    public function getViewLink() : string
    {
        $viewLink = $this->getDefaultEmbedLink();
        return str_replace('/'.embed_slug().'/' ,'/'.view_slug().'/', $viewLink);
    }



    public function season()
    {
        if($this->seasonObj === null){

            $this->seasonObj = new Season();

            if($this->isEpisode()) {
                $seasonModel = new SeasonModel();
                $season = $seasonModel->where('id', $this->season_id)
                                      ->first();
                if(! empty($season)){
                    $this->seasonObj = $season;
                }

                unset($seasonModel);

            }
        }

        return  $this->seasonObj;

    }

    public function series()
    {
        return $this->season()->series();
    }

    public function genres()
    {
        if($this->genres === null){

            $movieGenreModel = new MovieGenreModel();
            $this->genres = [];

            $genres = $movieGenreModel->getGenresByMovieId( $this->id );

            if($genres !== null){
                $this->genres = $genres;
            }

            unset($movieGenreModel);

        }

        return  $this->genres;
    }

    public function links($type = null)
    {
        if(empty( $this->tmpLinks[$type] ) ) {
            $linksModel = new \App\Models\LinkModel();
            $results = $linksModel->findByMovieId( $this->id, $type );
            if( $results !== null ) {
                $this->tmpLinks[$type] = $results;
            }
        }
        return $this->tmpLinks[$type] ?? [];
    }

    public function hasLinks($type = null)
    {
        return !empty( $this->links( $type ) );
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

    public function isEpisode()
    {
        return $this->type  == 'episode';
    }

    public function getUniqMovieId()
    {
        return ! empty($this->imdb_id) ? $this->imdb_id : $this->tmdb_id;
    }






}