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

namespace App\Validation;


use Config\Database;

class CustomRules
{
    public function exist($str, $value, $data, &$error = '')
    {


        list($table, $column) = explode('.', $value, 2);
        $results = Database::connect()->table($table)
                                      ->where($column, $str)
                                      ->select('id')
                                      ->get(1);

        if(! $results->getNumRows() > 0) {
            $error = lang("{$table} does not exist");
            return false;
        }

        return true;
    }

    public function both_unique($str, $value, $data, &$error = '')
    {
        list($table, $columns) = explode('.', $value, 2);
        $columns = explode(',', $columns);

        $builder = Database::connect()->table($table);

        foreach ($columns as  $val) {
            if(array_key_exists($val, $data)){
                $builder->where($val, $data[$val]);
            }
        }

        if(isset($data['id'])) {
            $builder->whereNotIn('id',  [$data['id']]);
        }

        $results = $builder->get(1)->getNumRows();

        if($results > 0){
            return false;
        }

        return $results === 0;
    }

    public function valid_imdb_id($str = null, &$error = null)
    {
        if (empty($str)) {
            return false;
        }

        if(! preg_match('/^tt[0-9]+$/', $str)) {
            $error = lang("Invalid Imdb Id");
            return false;
        }

        return true;
    }

    public function valid_tmdb_id($str = null, &$error = null)
    {
        if (empty($str)) {
            return false;
        }

        if(! preg_match('/^[0-9]+$/', $str)) {
            $error = lang("Invalid Tmdb Id");
            return false;
        }

        return true;
    }

    public function valid_movie_id($str = null, &$error = null)
    {
        if (empty($str)) {
            return false;
        }

        if(! preg_match('/^[tt]{0,2}[0-9]+$/', $str)) {
            $error = lang("Invalid Imdb or Tmdb Id");
            return false;
        }

        return true;
    }

    public function valid_lang_code($str = null, &$error = null)
    {
        if (empty($str)) {
            return false;
        }

        $langList = get_lang_list( true );

        if(empty($langList) || ! array_key_exists($str, $langList)) {
            $error = lang("Invalid language code");
            return false;
        }

        return true;
    }

    public function valid_math_captcha($str = null, &$error = null)
    {
        if(empty($str))
            return null;

        $captcha = service('math_captcha');
        $success = $captcha->isValid( $str );

        if(! $success) {
            $error = lang('Captcha.invalid');
        }

        $captcha->destroy();

        return  $success;


    }

    public function valid_payment_method($str = null, &$error = null)
    {
        if(empty($str))
            return null;

        $success = in_array($str, get_payout_payment_methods());

        if(! $success) {
            $error = lang('Invalid Payment Method');
        }

        return  $success;
    }

}