<?php


if(! function_exists('pirate_format_links_stats'))
{
    function theme_format_links_stats($status): string
    {
        $html = '';
        switch ($status) {
            case \App\Models\LinkModel::STATUS_APPROVED :
                $html = '<span class="text-success"> ' . ucwords($status) . ' </span>';
                break;
            case \App\Models\LinkModel::STATUS_PENDING :
                $html = '<span class="text-secondary"> ' . ucwords($status) . ' </span>';
                break;
            default :
                $html = '<span class="text-danger"> ' . ucwords($status) . ' </span>';
                break;
        }

        return $html;
    }
}


if(! function_exists( 'the_theme_table_list' ) )
{
    function the_theme_table_list($movies, $isMovies = true, $datatable = true)
    {
        include view_path( theme_path("/user/__partials/table_list") );
    }
}

if(! function_exists('display_alerts'))
{
    function display_alerts( $attr = '' ): string
    {
        $alert = '';
        $alerts = get_alerts();
        if(! empty($alerts)){
            $type = key($alerts);
            $alerts = array_shift($alerts);
            $msg = array_shift($alerts);

            switch ($type) {
                case 'success':
                    $alert = ' <div class="alert alert-success">' . esc( $msg ) . '</div>';
                    break;
                case 'danger':
                    $alert = ' <div class="alert alert-danger">' . esc( $msg ) . '</div>';
                    break;
                case 'warning':
                    $alert = ' <div class="alert alert-secondary">' . esc( $msg ) . '</div>';
                    break;
            }

            if(! empty( $alert ) ){
                $alert = '<div class="content errors-content mt-0 '. $attr .'">' . $alert . '</div>';
            }

        }

        return $alert;
    }
}

if(! function_exists('pirate_format_stars_status'))
{
    function pirate_format_stars_status( $status, $ucwords = false )
    {
        switch ($status) {
            case \App\Models\EarningsModel::STATUS_CREDITED:
                $class = 'text-success';
                break;
            case \App\Models\EarningsModel::STATUS_PENDING:
                $class = 'text-secondary';
                break;
            case \App\Models\EarningsModel::STATUS_REJECTED:
                $class = 'text-danger';
                break;
            default:
                $class = 'text-primary';
                break;
        }
        if($ucwords) $status = ucwords($status);
        return '<span class="'. $class .'">'. $status .'</span>';
    }
}