<?php

/**
            ▒█░░▒█ ▀█▀ ▒█▀▀█ ▒█▀▀▀ █▀▄▀█ █▀▀▄ █▀▀ █▀▀▄
            ░▒█▒█░ ▒█░ ▒█▄▄█ ▒█▀▀▀ █░▀░█ █▀▀▄ █▀▀ █░░█
            ░░▀▄▀░ ▄█▄ ▒█░░░ ▒█▄▄▄ ▀░░░▀ ▀▀▀░ ▀▀▀ ▀▀▀░

 * ======================================================================
 *                  DON'T WASTE YOUR TIME IN HERE
 * ======================================================================
 */

namespace App\Libraries;

use CodeIgniter\I18n\Time;


class LicVip
{

    public static $gen = false;
    public static $sofia = null;
    public static $antMan = [];

    // check is trail
    public static function is_vip_lic_t_lop(): bool
    {
        return ! self::c_vip_lic_t_lv_1l_pol()
            && self::c_vip_lic_t_lv_2l_osp()
            && self::c_vip_lic_t_lv_3l_bnf();
    }

    // check product is active
    public static function is_vip_lic_ex_kop_nin(): bool
    {
//        return self::g_vip_lic_lnc_ky_fl_ldk() && self::is_vip_lic_lv_psd_don();
    }

    // check activation level passed
    public static function is_vip_lic_lv_psd_don()
    {
        return self::a_lv_1() == _NL__()
            && self::a_lv_2() == _NL__()
            && self::a_lv_3() == _NL__()
            && self::a_lv_4() == _NL__();
    }

    // check trail level 1 : return false (as true)
    public static function c_vip_lic_t_lv_1l_pol(): bool
    {
        $regD = get_lic_vip_r_date();
        if($ref = self::g_vip_lic_exp_dt_kon_lol( $regD )){
            if($ref > Time::now()->getTimestamp()){

                return false;

            }
        }

        return true;
    }

    // check trail level 2
    public static function c_vip_lic_t_lv_2l_osp(): bool
    {
        if(is_file(self::g_vip_lec_lv_2l_vr_fl_nm_lkj())){
            return true;
        }

        return false;
    }

    // check trail level 3 ( is trail init )
    public static function c_vip_lic_t_lv_3l_bnf(): bool
    {
        return get_config('__t') && ! get_config('__a');
    }

    public static function s_lic_vip_st_foo_noon($variable, $value){
        self::$antMan[$variable] = $value;
    }

    public static function __callstatic($name, $arguments){
        if(isset(self::$antMan[$name])){
            return self::$antMan[$name];
        }
        return null;
    }

    // check is trial ( check from date) trial lv 1
    public static function c_vip_lic_tl_psd_lfg()
    {
        $isT = __OEN__();

        $licVipDt = __KING_KONG__()(__DT_NJ__());
        $trialStartedDate = ! empty($licVipDt) ? __ENTER__()($licVipDt) : null;

        if($trialStartedDate){

            $trialPassed = false;
            $tnow = __T_NOW__();
            $startAt = __ENTER__()($tnow . __NOPE__());

            if($startAt < $trialStartedDate){
                $todayAt = __ENTER__()($tnow . __YEP__());
                $endAt = __ENTER__()($licVipDt . __YEP__());
                if($todayAt >= $endAt){
                    $trialPassed = true;
                }
            }

            if($trialPassed && __KING_KONG__()(__TOTO__()) == _NL__()){
                $isT = __ENO__();
                __KFC__()::{__DFL_LOL__()}(__MDL__P(), _NL__());
            }else{

                $__p = __MAD__()(__LOLLIPOP__())->{__CON__()}(__REQ__());
                if($__p !== null){
                    $__p->{__POL__()}( [__MOM__()=>__ENO__()]);
                    if($__p->{__HOL__()}()){
                        __MAD__()(__LOLLIPOP__())->{__KISS__()}(__REQ__(),[__MOM__()=>__ENO__()]);
                    }
                }
            }
        }

        return $isT;
    }

    public static function g_vip_lic_lnc_ky_fl_ldk()
    {

        $passed = false;



        $__yo = __DJ00__()(__P_ULR__()(__ZOO__(), __GET_IT__()));
        $nc = __PPA__(). base64_encode(__SHARE_IT__()(__LIC_K__()(), __LOOP__(),$__yo)) .__NONE__();
        if(__FUN__()($nc)){
            $__c = @__LOL_TEG_IT__()($nc);
            if(! empty($__c)){
                __KFC__()::{__DFL_LOL__()}(__JJJ__(), _NL__());
                $__d = __LOL_JJ__()(__PP_L__()($__c),__ABC__(), __LOL_DF__()(__OOO__()(__URY__()(), __HOT__())));

                if(! empty($__d)){
                    $__s = __EXP__l__()(__BRUSH__(), $__d);
                    list($license, $host) = $__s;
                    if($license == __LIC_K__()()){
                        __KFC__()::{__DFL_LOL__()}('a_lv_2', _NL__());
                        //check config
                        if(get_config('__a') == _NL__() && get_config('__t') == _NL__()){
                            __KFC__()::{__DFL_LOL__()}('a_lv_3', _NL__());
                            //check host
                            if($host == parse_url(current_url(), PHP_URL_HOST)){
                                __KFC__()::{__DFL_LOL__()}('a_lv_4', _NL__());
                                $passed = true;
                            }
                        }
                    }
                }
            }
        }

        return $passed;
    }

    public static function g_vip_lic_exp_dt_kon_lol( $dt )
    {
        if($expires = strtotime(self::g_vip_lec_mol_ddt_nb_awd(), strtotime($dt))){
            return $expires;
        }

        return null;
    }

    public static function g_vip_lec_lv_2l_vr_fl_nm_lkj(): string
    {
        __KFC__()::{__DFL_LOL__()}('t_lv_2', _NL__());
        return WRITEPATH . strtotime(get_lic_vip_r_date()) . self::g_vip_lec_mol_dsa_as_l();
    }

    // create trial version
    public static function c_vip_lec_tl_v_bl_lp()
    {
        $__t = __MAD__()(__LOLLIPOP__())->{__CON__()}(__TOTO__());
        if($__t !== null){
            $__t->{__POL__()}( [__MOM__()=>__ENO__()]);
            if($__t->{__HOL__()}()){
                __MAD__()(__LOLLIPOP__())->{__KISS__()}(__TOTO__(),[__MOM__()=>__ENO__()]);
                $__f=__BOY__().__ENTER__()(__T_NOW__()).self::g_vip_lec_mol_dsa_as_l();
                if(!__FBA__()($__f)){
                    @__FBI__()($__f,__CJ_NOTE__());
                    if(__FBA__()($__f)){
                        $__r = __MAD__()(__LOLLIPOP__())->{__CON__()}(__DT_NJ__());
                        if($__r !== null) {
                            $__r->{__POL__()}([__MOM__()=>__T_NOW__()]);
                            if($__r->{__HOL__()}()){
                                __MAD__()(__LOLLIPOP__())->{__KISS__()}(__DT_NJ__(),[__MOM__() =>__T_NOW__()]);
                                $__d = __MAD__()(__LOLLIPOP__())->{__CON__()}(__KGF__());
                                if($__d !== null){
                                    $__a__ = sc_enc_spc(__BASH_1__(), get_doll());
                                    $__d->{__POL__()}( [__MOM__()=>$__a__]);
                                    if($__d->{__HOL__()}()){
                                        __MAD__()(__LOLLIPOP__())->{__KISS__()}(__KGF__(),[__MOM__() =>$__a__]);__CALLED__();
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }


    private static function g_vip_lec_mol_ddt_nb_awd()
    {
        return base64_decode('KzcgZGF5cw==');
    }

    private static function g_vip_lec_mol_dsa_as_l()
    {
        return base64_decode('LnR4dA==');
    }

    private static function g_vip_lec_fdv_ldo_s()
    {
        return base64_decode('bGljZW5zZS50eHQ=');
    }



}