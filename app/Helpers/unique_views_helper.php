<?php

helper('cookie');

if(! function_exists( 'is_movie_viewed' ))
{
    function is_movie_viewed( $uniqId ): bool
    {
        return get_cookie("viewed_{$uniqId}") == 1;
    }
}

if(! function_exists( 'movie_viewed' ))
{
    function movie_viewed( $uniqId, $path = '/' )
    {
        if(get_cookie("viewed_{$uniqId}") != 1) {
            $exp = 60 * 60 * \App\Models\VisitorsModel::VISIT_EXPIRING_HOURS;
            set_cookie("viewed_{$uniqId}", 1, $exp , '', $path);
        }
    }
}


if(! function_exists( 'has_permit_translate' ))
{
    function has_permit_translate( )
    {

    }
}
