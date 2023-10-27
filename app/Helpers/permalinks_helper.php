<?php


if(! function_exists('get_allowed_movies_slug_types'))
{
    function get_allowed_movies_slug_types(): array
    {
        return [
            'imdb_short',
            'imdb_long',
            'tmdb_short',
            'tmdb_long',
            'general_id_short',
            'general_id_long',
            'custom_dynamic'
        ];
    }
}

if(! function_exists('get_default_movies_permalink_type'))
{
    function get_default_movies_permalink_type()
    {
        return get_config('default_movies_permalink_type');
    }
}


if(! function_exists('is_movies_dynamic_slug_enabled'))
{
    function is_movies_dynamic_slug_enabled(): bool
    {
        return get_default_movies_permalink_type() == 'custom_dynamic';
    }
}



if(! function_exists('create_custom_movie_slug'))
{
    function create_custom_movie_slug( $movie ) : ?string
    {
        if(! ($movie instanceof \App\Entities\Movie || $movie instanceof \App\Entities\Series)){
            return null;
        }

        $pattern = get_config('series_permalink_pattern');
        $isMovie = false;
        if($movie instanceof \App\Entities\Movie){
            if(! empty($movie->type)){
                $isMovie = true;
                $pattern = ! $movie->isEpisode() ? get_config('movie_permalink_pattern') : get_config('episode_permalink_pattern');
            }
        }

        $pattern = str_replace(' ', '', $pattern);
        $slug = '';

        if(! empty($pattern)){

            $slug = $pattern;

            $title = str_replace(' & ', ' and ', $movie->title);
            $seriesTitle = str_replace(' & ', ' and ', $movie->series_title);

            $data = [
                'tv_title'  => ! empty($seriesTitle) ? $seriesTitle : $title,
                'tv_imdb'   => ! empty($movie->series_imdb_id) ? $movie->series_imdb_id : $movie->imdb_id,
                'tv_tmdb'   => ! empty($movie->series_tmdb_id) ? $movie->series_tmdb_id : $movie->tmdb_id,
                'year'      => $movie->getReleasedYear()
            ];

            if( $isMovie ){

                $mvData = [
                    'mv_title'  => $title,
                    'ep_title'  => $title,
                    'mv_imdb'   => $movie->imdb_id,
                    'ep_imdb'   => $movie->imdb_id,
                    'mv_tmdb'   => $movie->tmdb_id,
                    'ep_tmdb'   => $movie->tmdb_id,
                    'season'      => $movie->season,
                    'episode'      => $movie->episode
                ];

                $data = $data + $mvData;
            }


            foreach ($data as $key => $val) {
                $key = '{'. strtoupper($key) .'}';
                $slug = str_replace($key, $val, $slug);
            }

        }else{

            $slug = $movie->title;

        }

        $slug = url_title($slug, '-', true);
        $separator = $isMovie ? '-' : '--';
        $slug =  $movie->id . $separator . $slug;
        return $slug;
    }
}