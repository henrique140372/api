<?php


if(! function_exists('theme_path'))
{
    function theme_path($path = ''): string
    {
        if(! empty($path)){
            $path = ltrim($path, '/');
            $path = '/' . $path;
        }

        return  'themes/' .  default_theme_name() . $path;
    }
}

if(! function_exists('theme_assets'))
{
    function theme_assets($path = ''): string
    {
        if(! empty($path)){
            $path = ltrim($path, '/');
            $path = '/' . $path;
        }

        $file =  'themes/' .  default_theme_name() . $path;
        return site_url( $file );
    }
}

if(! function_exists('admin_assets'))
{
    function admin_assets($path = ''): string
    {
        if(! empty($path)){
            $path = ltrim($path, '/');
            $path = '/' . $path;
        }

        $file =  'admin-assets/' . $path;
        return site_url( $file );
    }
}

if(! function_exists('getResolutionFormatOptions'))
{
    function getResolutionFormatOptions()
    {
        $options = [ '' => '' ];
        $resolutionFormats = config('Settings')->download_resolution_formats;

        if(! empty($resolutionFormats)) {
            foreach ($resolutionFormats as $resolution) {
                $options[$resolution] = $resolution;
            }
        }

        return $options;
    }
}

if(! function_exists('getQualityFormatOptions'))
{
    function getQualityFormatOptions()
    {
        $options = [ '' => '' ];
        $qualityFormats = config('Settings')->download_quality_formats;

        if(! empty($qualityFormats)) {
            foreach ($qualityFormats as $quality) {
                $options[$quality] = $quality;
            }
        }

        return $options;
    }
}


if(! function_exists('get_stream_types'))
{
    function get_stream_types(): array
    {
        $options = [];
        $streamTypes = get_config('stream_types');

        if(! empty($streamTypes)) {
            $options = [ '' => '' ];
            foreach ($streamTypes as $type) {
                $options[$type] = $type;
            }
        }

        return $options;
    }
}


if(! function_exists( 'format_links_status' ))
{
    function format_links_status($status)
    {
        $html = '';

        switch ($status) {
            case \App\Models\LinkModel::STATUS_APPROVED :
                $html = '<span class="text-success status-val"> ' . ucwords($status) . ' </span>';
                break;
            case \App\Models\LinkModel::STATUS_PENDING :
                $html = '<span class="text-warning status-val"> ' . ucwords($status) . ' </span>';
                break;
            default :
                $html = '<span class="text-danger status-val"> ' . ucwords($status) . ' </span>';
                break;
        }

        return $html;
    }
}


if(! function_exists( 'the_movie_item' ) )
{
    function the_movie_item($movie, $imdbBased = false, $lazyLoading = true)
    {
        include view_path( theme_path("__partials/movie-item") );
    }
}

if(! function_exists( 'the_req_movie_item' ) )
{
    function the_req_movie_item(array $data )
    {
        include view_path( theme_path("__partials/req-movie-item") );
    }
}

if(! function_exists( 'the_admin_discover_page' ) )
{
    function the_admin_discover_page( $results, $page = 1, $total_page = 0 )
    {
        include view_path( "/admin/discover/x_panels/movies-page" );
    }
}


if(! function_exists( 'the_admin_suggest_page' ) )
{
    function the_admin_suggest_page( $results)
    {
        include view_path( "/admin/movies/form_x_panels/suggest" );
    }
}

if(! function_exists( 'the_embed_player' ) )
{
    function the_embed_player($activeMovie)
    {
        include view_path( theme_path('__partials/embed-player') );
    }
}

if(! function_exists( 'the_math_captcha' ) )
{
    function the_math_captcha($isCenter = false)
    {
        include view_path( theme_path('__partials/math-captcha') );
    }
}

if(! function_exists( 'the_embed_links_group' ) )
{
    function the_embed_links_group($activeMovie = null)
    {
        include view_path( theme_path("__partials/embed-links-group") );
    }
}



if(! function_exists( 'the_movie_meta_info' ) )
{
    function the_movie_meta_info($activeMovie = null)
    {
        include view_path( theme_path("__partials/movie-meta-info") );
    }
}

if(! function_exists( 'the_episode_label' ))
{
    function the_episode_label($season, $episode)
    {
        $sea = sprintf("%02d", $season);
        $epi = sprintf("%02d", $episode);

        return "S{$sea} : E{$epi}";
    }
}

if(! function_exists( 'get_genres_links' ))
{
    function get_genres_links( $genres , $type = 'movies')
    {
        $links = [];
        foreach ($genres as $genre) {
            $links[] = anchor("/library/{$type}?genres={$genre->name}", ucwords($genre->name), [
                'class' => ''
            ]);
        }
        return ! empty($links) ? implode(', ', $links) : '';
    }
}

if(! function_exists('get_movie_id_data'))
{
    function get_movie_id_data(\App\Entities\Movie $item, $el = null, $t = null)
    {
        $dataId = $dataType = null;
        $prepix = $t == 'series' ? 'series_' : '';

        $imdbId = $prepix . 'imdb_id';
        $tmdbId = $prepix . 'tmdb_id';
        $id = $prepix . 'id';

        $slugType = get_config('default_embed_slug_type');
        if($slugType == 'imdb'){
            if(! empty($item->{$imdbId})){
                $dataId = $item->{$imdbId};
                $dataType = 'imdb';
            }
        }elseif($slugType == 'tmdb'){
            if(! empty($item->{$tmdbId})){
                $dataId = $item->{$tmdbId};
                $dataType = 'tmdb';
            }
        }
        if(! empty($item->{$id}) && empty($dataId)) {
            $dataId = encode_id( $item->{$id} );
            $dataType = 'id';
        }

        if($el !== null) {
            if($el == 'id'){
                return $dataId;
            }elseif($el == 'type'){
                return $dataType;
            }
        }

        return [
            'id'    => $dataId,
            'type'  => $dataType
        ];
    }
}

if(! function_exists( 'format_seasons_list' ))
{
    function format_seasons_list($activeMovie,  $seasons )
    {
        $seasonsOptions = [];
        $episodesList = '';
        $seasonsList = '';



        foreach ($seasons as $season) {

            if(empty( $season->episodes ))
                continue;

            $seasonSelected = $season->season == $activeMovie->season;
            $selectedEpisode = 0;

            $seasonsOptions[$season->season] = "Season {$season->season}";

            $episodesOptions = '';
            foreach ($season->episodes as $episode) {

                $episodeLabel = "Episode {$episode->episode} : {$episode->title}";

                $selected = '';
                $episodeSelected = $episode->episode == $activeMovie->episode;
                if($seasonSelected && $episodeSelected) {
                    $selected = 'selected="selected"';
                    $selectedEpisode = $episode->episode;
                }

                $idData = get_movie_id_data( $episode );
                $dataId = $idData['id'];
                $dataType = $idData['type'];

                $episodesOptions .= "<option value=\"{$episode->episode}\" data-id=\"{$dataId}\" data-type=\"{$dataType}\"  {$selected}>";
                $episodesOptions .= $episodeLabel;
                $episodesOptions .= '</option>';

            }

            $hidden = ! $selectedEpisode ? 'display:none' : '';


            $episodesList .= '<select class="form-control episodes-select" id="sea-'.$season->season.'--episodes" style="'.$hidden.'">' . $episodesOptions . '</select>';



        }

        $seasonsList .= form_dropdown([
            'id' => 'season-select',
            'class' => 'form-control',
            'style' => 'max-width: 15rem',
            'options' => $seasonsOptions,
            'selected' => $activeMovie->season
        ]);

        return "{$seasonsList} {$episodesList}";

    }



}

if(! function_exists('has_display_banner_ad'))
{
    function has_display_banner_ad(string $identity,  array $ads): bool
    {
        if(isset( $ads[$identity] )){

            $ad = $ads[$identity];
            return  ! empty( $ad->ad_code );
        }

        return false;
    }
}

if(! function_exists('display_banner_ad'))
{
    function display_banner_ad(string $identity,  array $ads, $type = '728')
    {
        if(isset( $ads[$identity] )){

            $ad = $ads[$identity];
            $adCode = ! empty($ad->ad_code) ? base64_decode( $ad->ad_code ) : '' ;
            if(! empty($adCode)){

                $html  = '<div class="content">';
                $html .= '<div class="ve-ad--wrap ve-ad--'. $type .'">';
                $html .= $adCode;
                $html .= '</div>';
                $html .= '</div>';

                return $html;

            }

        }

        return '';

    }
}

if(! function_exists('display_pop_ad'))
{
    function display_pop_ad(array $ads)
    {
        $popAdCode = '';
        foreach ($ads as $ad) {
            if($ad->type == 'popad'){
                if(! empty($ad->ad_code)){
                    $popAdCode = base64_decode( $ad->ad_code );
                }
                break;
            }
        }

        return $popAdCode;

    }
}
if(! function_exists('create_stream_servers'))
{
    function create_stream_servers( $linkList )
    {
        $i = 0;
        foreach ($linkList as $group => $links) {

            ?>
            <div class="dropdown servers mr-5" style=" <?= $i != 0 ? 'display:none' : '' ?>" id="<?= $group ?>-servers" >
                <button class="btn active-server" data-toggle="dropdown"  type="button">
                    <i class="fa fa-server" aria-hidden="true"></i>&nbsp;
                    <span class="name"><?= reset( $links )['name'] ?></span>&nbsp;
                    <i class="fa fa-angle-down ml-5" aria-hidden="true"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdown-toggle-btn-1">
                    <?php
                        foreach ($links as $id => $link) {
                            $statusClass = ! $link['is_reported'] ? 'text-success' : 'text-secondary';
                            $linkHtml = '<a href="javascript:void(0)" onClick="Player.play(false, this)" class="server dropdown-item"
                             data-id="' . $id . '"> ' . esc( $link['name'] );
                            if(get_config('color_dot_on_player_links')){
                                $linkHtml .= '<span class="float-right status-dot '. $statusClass .'" > <i class="fa fa-circle"></i> </span>';
                            }
                            $linkHtml .= '</a>';

                            echo $linkHtml;
                        }
                    ?>
                </div>
            </div>

                <?php

            $i++;
        }
    }
}

if(! function_exists( 'create_stream_servers_groups' ))
{
    function create_stream_servers_groups( $links )
    {
        $groups = array_keys( $links );
        if(! empty($groups)) {
            $groupName = reset( $groups );

    ?>

        <div class="dropdown selection  mr-5  <?= count($groups) == 1 ? 'd-none' : '' ?> " id="server-groups"   >

            <button class="btn active-server-group" data-toggle="dropdown"  type="button" >
                <i class="fa fa-music" aria-hidden="true"></i>&nbsp;
                <span class="name"><?= $groupName ?></span>&nbsp;
                <i class="fa fa-angle-down ml-5" aria-hidden="true"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdown-toggle-btn-1">
                <?php
                foreach ($groups as  $group) {
                    echo '<a href="javascript:void(0)" onClick="Player.changeGroup(this)" class="server-group dropdown-item" data-id="' . $group . '"> ' . esc( $group ) . ' </a>';
                }
                ?>
            </div>
        </div>

<?php
        }
    }
}

if(! function_exists( 'create_stream_servers_list' ))
{
    function create_stream_servers_list( $links )
    {
        $serversList = [];
        if(! empty($links)){



            // Attempt to create links group
            foreach ($links as  $link) {
                if(! empty($link->quality) && ! isset($serversList[$link->quality])){
                    $serversList[$link->quality] = [];
                }
            }

            // create default link group if it is empty
            $linkGroup = '_default';
            if(empty( $serversList )){
                $serversList[$linkGroup] = [];
            }

            if(! empty(get_max_stream_servers_per_group())){
                // Randomize the order of the links in the group
                shuffle($links);
            }

            foreach ($links as $key => $link) {

                //encoded id
                $encId = encode_id( $link->id );

                // Link Group
                if( ! empty( $serversList )){
                    $linkGroup = ! isset($serversList[$link->quality]) ?  key( $serversList ) : $link->quality;
                }

                // added links to group
                $numOfLinksInGroup = 0;
                if(isset($serversList[$linkGroup])){
                    $numOfLinksInGroup =  is_array($serversList[$linkGroup]) ? count($serversList[$linkGroup]) : 0;
                }

                if(! empty(get_max_stream_servers_per_group())){
                    if($numOfLinksInGroup == get_max_stream_servers_per_group()){
                        continue;
                    }
                }

                if(get_config('is_use_anonymous_stream_server')){
                    $hostName = get_config('anonymous_stream_server_name');
                    $hostName = ! empty($hostName) ? $hostName : 'server';
                    $host = $hostName . "  " . ($numOfLinksInGroup + 1);

                }else{

                    $host = $link->getHost( true );

                }


                $hData = [
                    'name' => $host,
                    'is_reported' => $link->isReported()
                ];

                //create server list
                if($host != get_config('default_server')){

                    if(isset($serversList[$linkGroup])){
                        $serversList[$linkGroup][$encId] = $hData;
                    }else{
                        $serversList[$encId] = $hData;
                    }

                }else{

                    if(isset($serversList[$linkGroup])){
                        $serversList[$linkGroup] = [ $encId => $hData ] + $serversList[$linkGroup];
                    }else{
                        $serversList = [ $encId => $hData ] + $serversList;
                    }

                }
            }
        }

        return $serversList;
    }
}


if(! function_exists('get_page_title'))
{
    function get_page_title( $title )
    {
        if(! empty($title)){

            $title .= ' - ' . site_name();

        }

        return $title;
    }
}

if(! function_exists('site_logo'))
{
    function site_logo(): string
    {
        $logoName = get_config('site_logo');
        return site_url('/uploads/' . $logoName);
    }
}

if(! function_exists('site_favicon'))
{
    function site_favicon(): string
    {
        $logoName = get_config('site_favicon');
        return site_url('/uploads/' . $logoName);
    }
}

if(! function_exists('has_site_logo'))
{
    function has_site_logo()
    {
        $logoName = get_config('site_logo');
        if(is_file( FCPATH . 'uploads/' . $logoName )){
            return true;
        }
        return false;
    }
}

if(! function_exists('has_site_favicon'))
{
    function has_site_favicon()
    {
        $logoName = get_config('site_favicon');
        if(is_file( FCPATH . 'uploads/' . $logoName )){
            return true;
        }
        return false;
    }
}

if(! function_exists('site_name'))
{
    function site_name(): string
    {
        return get_config('site_name');
    }
}

if(! function_exists('display_country_list'))
{
    function display_country_list( $countries ): string
    {
        if(! empty( $countries )){

            $results = [];

            foreach ($countries as $country) {
                $results[] = anchor(
                                library_url( [ 'country' => $country ] ),
                                $country
                            );
            }

            return implode(', ' , $results);
        }

        return '';
    }
}

if(! function_exists('display_language_list'))
{
    function display_language_list( $languages ): string
    {
        if(! empty( $languages )){

            $results = [];

            foreach ($languages as $lang) {
                $results[] = anchor(
                    library_url( [ 'lang' => $lang ] ),
                    ucwords( $lang )
                );
            }

            return implode(', ' , $results);
        }

        return '';
    }
}




if(! function_exists('get_footer_menus'))
{
    function get_footer_menus(): array
    {
        $pageModel = new \App\Models\PagesModel();
        $pages = $pageModel->select('id, title, slug')
                           ->publicPages()
                           ->findAll();

        return ! empty( $pages ) ? $pages : [];
    }
}

if(! function_exists('display_reliability_val'))
{
    function display_reliability_val( $val ): string
    {
        $class = 'text-danger';
        if($val >= 75){
            $class = 'text-success';
        }

        return "<span class=\"{$class}\">{$val}</span>";
    }
}

if(! function_exists('is_link_btn_disabled'))
{
    function is_link_btn_disabled(\App\Entities\Link $link, $isApproved = false  ): string
    {
        $isDisabled = false;

        if(! $link->user()->isUser() ){
            $isDisabled = true;
        }else{

            if($isApproved){

                if($link->isActive() || $link->isBroken()){
                    $isDisabled = true;
                }

            }else{

                if($link->isRejected() || $link->isBroken()){
                    $isDisabled = true;
                }

            }

        }

        return $isDisabled ? 'disabled="disabled"' : '';

    }
}


if(! function_exists('create_episode_meta_list'))
{
    function create_episode_meta_list(array $seasons): array
    {
        $list = [];
        foreach ($seasons as $season) {

            $episodeList = [];

            if(! empty($season->episodes)){
                foreach ($season->episodes as $episode) {
                    if(! isset($episodeList[$episode->episode])){
                        $episodeList[$episode->episode] = [
                            'is_ok'  => 1
                        ];
                    }
                }
            }

            if(! empty($season->total_episodes)){
                for ($i = 1; $i <= $season->total_episodes; $i++){
                    if(! isset($episodeList[$i])){
                        $episodeList[$i] = [
                            'is_ok'  => 0
                        ];
                    }
                }
            }

            ksort($episodeList);
            $list[$season->season] = $episodeList;
        }

        return $list;
    }
}

if(! function_exists('clean_undscr_txt'))
{
    function clean_undscr_txt( $txt ): string
    {
        $txt = str_replace('_', ' ', $txt);
        return ucwords($txt);
    }
}


if(! function_exists('format_stars_txt'))
{
    function format_stars_txt( $stars ): string
    {
        return $stars == 1 ? lang('General.star') : lang('General.stars');
    }
}

if(! function_exists('create_keywords_list'))
{
    function create_keywords_list( $keywords, $title = null ): string
    {
        $results = [];
        $keywords = str_to_array(strtolower((string)$keywords));
        $defaultKeywords = str_to_array(strtolower(get_config('default_keywords')));
        $blacklistedKeywords = str_to_array(strtolower(get_config('blacklisted_keywords')));

        $results = array_merge($keywords, $defaultKeywords);

        if(get_config('keywords_from_title') && $title !== null){
            $titleData = explode(' ', $title);
            foreach ($titleData as  $v) {
                $v = str_replace(' ', '', $v);
                if(strlen($v) > 2) {
                    $results[] = strtolower($v);
                }
            }
        }

        if(! empty($results) && ! empty($blacklistedKeywords)){
            foreach ($results as $k => $v) {
                $v = str_replace(' ', '', $v);
                if(in_array($v, $blacklistedKeywords)){
                    unset($results[$k]);
                }
            }
        }


        return implode(', ', $results);
    }
}



if(! function_exists('get_footer_links'))
{
    function get_footer_links(  ): array
    {
        $results = [];
        $links = get_config('footer_links');
        if(! empty($links)){
            $links = explode(PHP_EOL , $links);
            if(! empty($links)){
               foreach ($links as $link) {
                   $linkData = explode('@', $link);
                   if(count($linkData) == 2){
                        list($title, $url) = $linkData;
                       $url = trim(str_replace(' ', '', $url));
                        if(filter_var($url, FILTER_VALIDATE_URL) === false){
                            $url = site_url($url);
                        }
                        $results[] = [
                                'title' => $title,
                                'url'   => $url
                        ];
                   }
               }
            }
        }

        return $results;
    }
}




if(function_exists('view_path')){
// auto load theme function
    $funcFile = view_path (theme_path('/__functions') );
    if(is_file($funcFile)){
        require_once $funcFile;
    }
}



if(function_exists('is_logged')){
    // auto load admin theme function
    if(! is_user()){
        $funcFile = view_path ('/admin/functions');
        if(is_file($funcFile)){
            require_once $funcFile;
        }
    }
}

