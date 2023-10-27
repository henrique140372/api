<?php

if(! function_exists( 'get_config' ))
{
    function get_config( $var = null )
    {

      $config = config('Settings');

      if(empty( $var ))
          return  $config;

      if(property_exists($config, $var)){

          return $config->$var;

      }

      return null;

    }
}


if(! function_exists( 'is_config_init' ))
{
    function is_config_init( $var )
    {
        if(empty($var))
            return null;

        $val  = get_config( $var );

        return ! empty($val);

    }
}



if(! function_exists( 'is_download_enabled' ))
{
    function is_download_enabled()
    {
        return get_config( 'download_system' );
    }
}


if(! function_exists('link_slug'))
{
    function link_slug()
    {
        if(! empty( get_config( 'link_slug' ) )){
            return get_config( 'link_slug' );
        }
        return 'link';
    }
}

if(! function_exists('embed_slug'))
{
    function embed_slug()
    {
        if(! empty( get_config( 'embed_slug' ) )){
            return get_config( 'embed_slug' );
        }
        return 'embed';
    }
}

if(! function_exists('download_slug'))
{
    function download_slug()
    {
        if(! empty( get_config( 'download_slug' ) )){
            return get_config( 'download_slug' );
        }
        return 'download';
    }
}



if(! function_exists('view_slug'))
{
    function view_slug()
    {
        if(! empty( get_config( 'view_slug' ) )){
            return get_config( 'view_slug' );
        }
        return 'view';
    }
}

if(! function_exists('library_slug'))
{
    function library_slug()
    {
        if(! empty( get_config( 'library_slug' ) )){
            return get_config( 'library_slug' );
        }
        return 'library';
    }
}


if(! function_exists('is_web_page_cache_enabled'))
{
    function is_web_page_cache_enabled()
    {
        return get_config( 'web_page_cache' );
    }
}

if(! function_exists('is_countdown_timer_enabled'))
{
    function is_countdown_timer_enabled()
    {
        return get_config( 'is_count_down_timer' );
    }
}

if(! function_exists('is_referer_blocked'))
{
    function is_referer_blocked()
    {
        return get_config( 'is_referer_blocked' );
    }
}

if(! function_exists('footer_txt_content'))
{
    function footer_txt_content()
    {
        return get_config( 'footer_content' );
    }
}

if(! function_exists('site_copyright'))
{
    function site_copyright()
    {
        return get_config( 'site_copyright' );
    }
}


if(! function_exists('is_links_report_enabled'))
{
    function is_links_report_enabled()
    {
        return get_config( 'is_links_report' );
    }
}

if(! function_exists('is_real_time_import_enabled'))
{
    function is_real_time_import_enabled()
    {
        return get_config( 'real_time_import' );
    }
}


if(! function_exists('is_dl_captcha_enabled'))
{
    function is_dl_captcha_enabled()
    {
        return get_config( 'is_download_link_captcha' );
    }
}

if(! function_exists('is_request_captcha_enabled'))
{
    function is_request_captcha_enabled()
    {
        return get_config( 'is_request_captcha_enabled' );
    }
}


if(! function_exists('web_page_cache_time'))
{
    function web_page_cache_time()
    {
        return get_config( 'web_page_cache_duration' );
    }
}

if(! function_exists('footer_custom_codes'))
{
    function footer_custom_codes()
    {
        $codes =  get_config( 'custom_footer_codes' );
        if(! empty($codes)){
            $codes = base64_decode($codes);
        }
        return $codes;
    }
}

if(! function_exists('header_custom_codes'))
{
    function header_custom_codes()
    {
        $codes =  get_config( 'custom_header_codes' );
        if(! empty($codes)){
            $codes = base64_decode($codes);
        }
        return $codes;
    }
}

if(! function_exists('site_name'))
{
    function site_name()
    {
        return esc( get_config( 'site_name' ) );
    }
}


if(! function_exists('is_omdb_api_enbaled'))
{
    function is_omdb_api_enbaled()
    {
        return ! empty(get_config( 'omdb_api_key'));
    }
}

if(! function_exists('is_tmdb_api_enbaled'))
{
    function is_tmdb_api_enbaled()
    {
        return ! empty(get_config( 'tmdb_api_key'));
    }
}



if(! function_exists('get_stars_exchange_rate'))
{
    function get_stars_exchange_rate($withCurrencyCode = false)
    {
        $rate = get_config('stars_exchange_rate');
        if(! is_numeric($rate) || $rate <= 0){
            $rate = 1;
        }

        if($withCurrencyCode) {
            $rate .= ' ' . get_currency_code();
        }

        return  $rate;
    }
}

if(! function_exists('get_currency_code'))
{
    function get_currency_code(): string
    {
        return strtoupper(get_config('currency_code'));
    }
}



if(! function_exists('sidebar_disabled'))
{
    function sidebar_disabled()
    {
        return empty(get_config( 'is_sidebar_disabled'));
    }
}

if(! function_exists('is_media_download_to_server'))
{
    function is_media_download_to_server()
    {
        return get_config( 'is_media_download_to_server');
    }
}


if(! function_exists('default_theme_name'))
{
    function default_theme_name()
    {
        $theme = get_config( 'default_theme');
        if(empty($theme) || ! in_array($theme, ['pirate']) ){
            $theme = 'default';
        }
        return $theme;
    }
}


if(! function_exists('smtp_config'))
{
    function smtp_config( $config = null )
    {
        $settings = get_config('smtp_settings');
        if(! empty( $config )){

            if(array_key_exists($config, $settings )){

                return $settings[$config];

            }

            return null;
        }
        return $settings;
    }
}


if(! function_exists('is_user_email_verification_enabled'))
{
    function is_user_email_verification_enabled()
    {
        return get_config('user_email_verification');
    }
}

if(! function_exists('__a'))
{
    function __a()
    {
        return get_config( '__a');
    }
}


if(! function_exists('is_user_admin_approval_enabled'))
{
    function is_user_admin_approval_enabled()
    {
        return get_config('user_admin_approval');
    }
}

if(! function_exists('is_users_system_enabled'))
{
    function is_users_system_enabled()
    {
        return get_config( 'users_system');
    }
}

if(! function_exists('_pq'))
{
    function _pq()
    {
        return get_config( 'p_req');
    }
}

if(! function_exists('is_login_gcaptcha_enabled'))
{
    function is_login_gcaptcha_enabled()
    {
        return get_config( 'is_login_gcaptcha_enabled');
    }
}

if(! function_exists('i_lic_vip_2'))
{
    function i_lic_vip_2()
    {
        return get_config( 'i_lic_vip_2');
    }
}

if(! function_exists('is_contact_gcaptcha_enabled'))
{
    function is_contact_gcaptcha_enabled()
    {
        return get_config( 'is_contact_form_gcaptcha');
    }
}

if(! function_exists('is_register_gcaptcha_enabled'))
{
    function is_register_gcaptcha_enabled()
    {
        return get_config( 'is_register_gcaptcha_enabled');
    }
}

if(! function_exists('get_stars_by_earning_type'))
{
    function get_stars_by_earning_type( $type ): int
    {
        $type = 'stars_for_' . $type;
        $stars = get_config( $type );
        return is_numeric($stars) && $stars >= 0 ? (int) $stars : 0;
    }
}

if(! function_exists('get_lic_vip_r_date'))
{
    function get_lic_vip_r_date()
    {
        return get_config('lic_vip_r_date');
    }
}

if(! function_exists('get_license_key'))
{
    function get_license_key()
    {
        return get_config('license');
    }
}

if(! function_exists('get_payment_methods_for_payouts'))
{
    function get_payment_methods_for_payouts()
    {
        return get_config('payment_methods_for_payouts');
    }
}


if(! function_exists('is_earnings_method_enabled'))
{
    function is_earnings_method_enabled( $method ): bool
    {
        return get_stars_by_earning_type( $method ) != 0;
    }
}

if(! function_exists('is_views_analytics_system_enabled'))
{
    function is_views_analytics_system_enabled( ): bool
    {
        return get_config('views_anlytc_system');
    }
}

if(! function_exists('is_ref_rewards_system_enabled'))
{
    function is_ref_rewards_system_enabled( ): bool
    {
        return get_config('ref_rewards_system');
    }
}

if(! function_exists('get_max_stream_servers_per_group'))
{
    function get_max_stream_servers_per_group( )
    {
        $servers = get_config('max_stream_servers_per_group');
        if(! is_numeric($servers)){
            $servers = 0;
        }

        return $servers;
    }
}




if(! function_exists('get_payout_payment_methods'))
{
    function get_payout_payment_methods( ): array
    {
        $methods =  get_config('payment_methods_for_payouts');
        if(is_array($methods)){
            return  $methods;
        }

        return [];
    }
}

if(! function_exists('get_last_db_backup_date'))
{
    function get_last_db_backup_date( )
    {
        return get_config('last_db_backup_at');
    }
}

if(! function_exists('get_default_timezone'))
{
    function get_default_timezone( )
    {
        return get_config('last_db_backup_at');
    }
}

if(! function_exists('is_page_cached_enabled'))
{
    function is_page_cached_enabled( $page ): bool
    {
        $cachedPages = get_config('cached_pages');
        if(! empty($cachedPages)){
            if(isset($cachedPages[$page])){
                return true;
            }
        }

        return false;
    }
}

if(! function_exists('get_max_steaming_links_per_user'))
{
    function get_max_steaming_links_per_user( )
    {
        $links = get_config('max_steaming_links_per_user');
        if(!is_numeric($links) || $links <= 0){
            $links = 1;
        }

        return $links;
    }
}

if(! function_exists('get_max_download_links_per_user'))
{
    function get_max_download_links_per_user( )
    {
        $links = get_config('max_download_links_per_user');
        if(!is_numeric($links) || $links <= 0){
            $links = 1;
        }

        return $links;
    }
}

if(! function_exists('get_max_torrent_links_per_user'))
{
    function get_max_torrent_links_per_user( )
    {
        $links = get_config('max_torrent_links_per_user');
        if(!is_numeric($links) || $links <= 0){
            $links = 1;
        }

        return $links;
    }
}

