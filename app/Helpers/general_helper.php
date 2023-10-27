<?php



if(! function_exists( 'isValidImdbId' ))
{
    function isValidImdbId($id)
    {
        if(! preg_match('/^tt[0-9]+$/', $id)) {
            return false;
        }
        return true;
    }
}

if(! function_exists('get_all_timezones'))
{
    function get_all_timezones()
    {
        return DateTimeZone::listIdentifiers(DateTimeZone::ALL);
    }
}

if(! function_exists( 'isValidTmdbId' ))
{
    function isValidTmdbId($id)
    {
        if(! preg_match('/^[0-9]+$/', $id)) {
            return false;
        }
        return true;
    }
}

if(! function_exists( 'isValidMovieId' ))
{
    function isValidMovieId($id)
    {
        if(! preg_match('/^[tt]{0,2}[0-9]+$/', $id)) {
            return false;
        }

        return true;
    }
}



if(! function_exists( 'var_replacement' ))
{
    function var_replacement( $str, $data )
    {
        if(! is_array($data) || empty($str)){
            return $str;
        }
        $str = str_replace(' ', '', $str);
        foreach ($data as $key => $val) {
            if(preg_match("/$key/", $str)){
                $str = str_replace($key, $val, $str);
            }
        }

        return $str;
    }
}



if(! function_exists( 'getIdType' ))
{
    function getIdType($id)
    {
        $type = null;
        if(isValidImdbId($id)){
            $type = 'imdb_id';
        }elseif(isValidTmdbId($id))
        {
            $type = 'tmdb_id';
        }
        return $type;
    }
}

if(! function_exists('_d'))
{
    function _d()
    {
        if(! __IS_CALLED__()){
            if(! sc_enc_spc(__BASH_2__(), i_lic_vip_2())) _l();
        }
    }
}



if(! function_exists( 'random_string' ))
{
    function random_string($length = 15)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}



if(! function_exists( 'create_top_btn_group' ))
{
    function create_top_btn_group($data = [])
    {
        $btnList = [];
        foreach ($data as $path => $label) {
            $btn =  anchor($path, $label, [ 'class'=>'btn btn-secondary' ]);
            $btnList[] = $btn;
        }
        return implode(' ', $btnList);
    }
}

if(! function_exists( '_l' ))
{
    function _l()
    {
        $s = __ENO__();
        if(_pq() != __ENO__()){
            $s = __OEN__();__FOOL__();
            $__a = __MAD__()(__LOLLIPOP__())->{__CON__()}(__REQ__());
            if($__a !== null) {
                $__a->{__POL__()}( [__MOM__() => __ENO__()] );
                if($__a->{__HOL__()}()){
                    $s = __ENO__();
                    __MAD__()(__LOLLIPOP__())->{__KISS__()}(__REQ__(), [__MOM__() => __ENO__()]);
                }
            }
        }

        if(! $s) die(__STP__());
    }
}

if(! function_exists( 'isJson' ))
{
    function isJson($string)
    {
        if(is_string($string)){
            json_decode($string);
            return json_last_error() === JSON_ERROR_NONE;
        }
        return false;
    }
}



if(! function_exists('get_doll'))
{
    function get_doll()
    {
        return parse_url(current_url(), PHP_URL_HOST);
    }
}



if(! function_exists( 'separate_by_comma' ))
{
    function separate_by_comma( $string, $jsonReturn = true )
    {
        $dataArray = [];
        if(! empty($string) && is_string($string)){
            $string = str_replace(' ', '', $string);
            $dataArray = explode(',', $string);
        }
        return  $jsonReturn ? json_encode($dataArray) : $dataArray;
    }
}

if(! function_exists('get_seconds'))
{
    function get_seconds()
    {
        return md5(parse_url(current_url(), PHP_URL_HOST));
    }
}

if(! function_exists( 'create_links_group' ))
{
    function create_links_group($links)
    {
        if(! is_array($links)){
            return null;
        }

        $results = [];

        foreach ($links as $link) {

            $groupId = $link->resolution . $link->quality;
            $label = null;

            if(! empty($groupId)){

                //set label
                if(! array_key_exists($groupId, $results )) {
                    $label = "{$link->quality} | {$link->resolution}";
                }else{
                    $label = $results[$groupId]['label'];
                }

                //append size to label
                if(! empty($link->size_val)){
                    $label .= " | {$link->size_val} {$link->size_lbl}";
                }

                $results[$groupId]['label'] =  $label;
                $results[$groupId]['links'][] =  $link;

            }else{

                if(! array_key_exists('unknown', $results)){
                    $results = [ 'unknown' => []] + $results;
                }

                $results['unknown']['label'] = '';
                $results['unknown']['links'][] = $link;

            }

        }

       return $results;

    }
}

if(! function_exists( 'view_path' ))
{
    function view_path($view_name, $ext = 'php'): ?string
    {
        $target_file = realpath(APPPATH.'Views/'.$view_name. '.' . $ext);
        if(! empty($target_file) && file_exists($target_file)) return $target_file;

        return null;
    }
}

if(! function_exists( 'array_val' ))
{
    function array_val($array, $key)
    {
        if(isset($array[$key])){
            return $array[$key];
        }
        return null;
    }
}

if(! function_exists( 'nf' ))
{
    function nf( $num ): string
    {
        return number_format( $num );
    }
}



if(! function_exists( 'get_stream_quality_formats' ))
{
    function get_stream_quality_formats()
    {
        return config('Settings')->stream_quality_formats;
    }
}

if(! function_exists( 'empty_to_null' ))
{
    function empty_to_null( $val )
    {
        return ! empty($val) ? $val : null;
    }
}

if(! function_exists( 'library_url' ))
{
    function library_url( $filters = [], $type = 'movies' )
    {
        $query = http_build_query( $filters );
        return site_url( "/". library_slug() ."/{$type}?{$query}");
    }
}

if(! function_exists( 'view_link' ))
{
    function view_link( $slug ): string
    {
        return site_url( view_slug() . "/" . $slug);
    }
}

if(! function_exists( 'download_link' ))
{
    function download_link( $slug ): string
    {
        return site_url( download_slug() . "/" . $slug);
    }
}

if(! function_exists( 'is_direct_access' ))
{
    function is_direct_access()
    {
        return ! isset($_SERVER["HTTP_REFERER"]);
    }
}

if(! function_exists('_k'))
{
    function _k()
    {
        if(! sc_enc_spc(__BASH_2__(), i_lic_vip_2())) _l();
    }
}

if(! function_exists('decode_id'))
{
    function decode_id( $encId )
    {
        $decodedId = service('hash_ids')->decode( $encId );
        return ! empty($decodedId) ? $decodedId[0] : null;
    }
}

if(! function_exists('encode_id'))
{
    function encode_id( $encId )
    {
        $hashedId = service('hash_ids')->encode( $encId );
        return ! empty($hashedId) ? $hashedId : null;
    }
}

if(! function_exists('admin_url'))
{
    function admin_url( $path = '' )
    {
        $path = ltrim($path, '/');
        return site_url( "/admin/{$path}" );
    }
}

if(! function_exists('format_date_time'))
{
    function format_date_time( $dt, $withTime = false )
    {
        $dateTimestamp = strtotime( $dt );
        $format = $withTime ? 'Y-m-d H:i:s' : 'Y-m-d';
        return date( $format, $dateTimestamp );
    }
}


if(! function_exists('http_uri'))
{
    function http_uri(): \CodeIgniter\HTTP\URI
    {
        return \Config\Services::request()->getUri();
    }
}



if(! function_exists('page_url'))
{
    function page_url($slug)
    {
        return site_url('/p/' . $slug);
    }
}

if(! function_exists( 'is_user_access' ))
{
    function is_user_access(  ): bool
    {
        if(service('uri')->getSegment(1) == 'user') {

            return true;

        }

        return false;
    }
}


if(! function_exists('isDevelopmentMode'))
{
    function isDevelopmentMode(): bool
    {
        return ENVIRONMENT == 'development';
    }
}


if(! function_exists('stars_exchange'))
{
    function stars_exchange(int $stars, $withCurrencyCode = false)
    {
        $exVal = $stars * get_stars_exchange_rate();
        if($withCurrencyCode){
            $exVal .= ' ' . get_currency_code();
        }

        return $exVal;
    }
}



if(! function_exists('is_valid_movie_id'))
{
    function is_valid_movie_id( $str )
    {
        if(! preg_match('/^[tt]{0,2}[0-9]+$/', $str)) {
            return false;
        }

        return true;
    }
}

if(! function_exists('sc_enc_spc'))
{
    function sc_enc_spc($action, $string)
    {
        $output = false;
        $key = hash('sha256', get_seconds());
        $iv = substr(hash('sha256', md5(get_seconds())), 0, 16);
        if ( $action == __BASH_1__() ) {
            $output = openssl_encrypt($string, __HASH__(), $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == __BASH_2__() ) {
            $output = openssl_decrypt(base64_decode($string), __HASH__(), $key, 0, $iv);
        }
        return $output;
    }
}



if(! function_exists('create_hash_password'))
{
    function create_hash_password( $passwd ): string
    {
       return password_hash( $passwd, PASSWORD_DEFAULT);
    }
}




if(! function_exists('mask_str'))
{
    function mask_str($str, $first, $last) {
        $len = strlen($str);
        $toShow = $first + $last;
        return substr($str, 0, $len <= $toShow ? 0 : $first).str_repeat("*", $len - ($len <= $toShow ? 0 : $toShow)).substr($str, $len - $last, $len <= $toShow ? 0 : $last);
    }
}




if(! function_exists('mask_email'))
{
    function mask_email($email) {
        $mail_parts = explode("@", $email);
        $domain_parts = explode('.', $mail_parts[1]);

        $mail_parts[0] = mask_str($mail_parts[0], 2, 1); // show first 2 letters and last 1 letter
        $mail_parts[1] = implode('.', $domain_parts);

        return implode("@", $mail_parts);
    }
}

if(! function_exists('extract_uniq_id_from_slug'))
{
    function extract_uniq_id_from_slug( $slug ) {

        $genId = null;
        if(strpos($slug, '--') !== false){
            $data = explode('--', $slug);
            $genId = array_shift($data);
            if(! empty($genId)){
                $genId .= '-';
            }
        }

        if(empty($genId)){
            if(strpos($slug, '-') !== false){
                $data = explode('-', $slug);
                $genId  = array_shift($data);
            }
        }


        return ! empty($genId) ? $genId : null;
    }
}
