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

namespace App\Controllers\Admin\Settings;



use App\Libraries\LicVip;
use CodeIgniter\Exceptions\PageNotFoundException;

class License extends BaseSettings
{

    public function index()
    {
        $title = 'License';



        $status = 'not_confirmed';
        if(! empty(get_license_key())){
            $status = 'invalid';
            if(LicVip::g_vip_lic_lnc_ky_fl_ldk()){
                $status = 'active';
            }
        }




        $data = compact('title', 'status');
        return view('admin/settings/license', $data);
    }


    public function check()
    {

        if(! $this->request->isAJAX()){
            throw new PageNotFoundException();
        }

        $success = 0;
        $licenseKey = $this->request->getGet('key');
        if(! empty($licenseKey)){

            $url = 'https://license.vipembed.com/check?' . http_build_query([
                        'license' => $licenseKey,
                        'domain'  => current_url()
                ]);

            $options = [
                'timeout' => 15,
                'http_errors' => false,
                'verify' => false
            ];
            $httpClient = \Config\Services::curlrequest( $options, null,null, false );
            $response = $httpClient->get($url);
            if($response->getStatusCode() == 200){
                $results = @json_decode($response->getBody(), true);
                if(! empty($results)){
                    if($results[_L_GOGO__()] == __KK__()){
                        $__yo = __DJ00__()(__P_ULR__()(__ZOO__(), __GET_IT__()));$success = 1;
                        $nc = APPPATH .  base64_encode(__SHARE_IT__()($licenseKey, __LOOP__(), $__yo)) . __NONE__();
                        if(! __FUN__()($nc)){
                            @__POO_IS_FOO__()($nc, $results[_SC_JOJO__()]);
                            if(__FUN__()($nc)){
                                $__l = __MAD__()(__LOLLIPOP__())->{__CON__()}(__DONALD_TRUMP__());
                                if($__l !== null){
                                    $__l->{__POL__()}( [__MOM__()=> $licenseKey ]);
                                    if($__l->{__HOL__()}()){
                                        __MAD__()(__LOLLIPOP__())->{__KISS__()}(__DONALD_TRUMP__(),[__MOM__()=>$licenseKey]);
                                        $k = __SCREENSHOT__()($results[_SC_JOJO__()], $results);
                                        if($k){
                                            $__l = __MAD__()(__LOLLIPOP__())->{__CON__()}($k);
                                            if($__l !== null){
                                                $__l->{__POL__()}( [__MOM__()=> $results[_SC_JOJO__()] ]);
                                                if($__l->{__HOL__()}()){
                                                    __MAD__()(__LOLLIPOP__())->{__KISS__()}($k,[__MOM__()=>$results[_SC_JOJO__()]]);
                                                    $__l = __MAD__()(__LOLLIPOP__())->{__CON__()}(__LOVE__());
                                                    if($__l !== null){
                                                        $__l->{__POL__()}( [__MOM__()=>__ENO__()]);
                                                        if($__l->{__HOL__()}()){
                                                            __MAD__()(__LOLLIPOP__())->{__KISS__()}(__LOVE__(),[__MOM__()=>__ENO__()]);
                                                            $__l = __MAD__()(__LOLLIPOP__())->{__CON__()}('license_type');
                                                            if($__l !== null){
                                                                $__l->{__POL__()}( [__MOM__()=>$results['type']]);
                                                                if($__l->{__HOL__()}()){
                                                                    __MAD__()(__LOLLIPOP__())->{__KISS__()}('license_type',[__MOM__()=>$results['type']]);
                                                                    __SES__()()->{__RIM__()}(__CATCH__());
                                                                    $__l = __MAD__()(__LOLLIPOP__())->{__CON__()}(__REQ__());
                                                                    if($__l !== null){
                                                                        $__l->{__POL__()}( [__MOM__()=>__OEN__()]);
                                                                        if($__l->{__HOL__()}()){
                                                                            __MAD__()(__LOLLIPOP__())->{__KISS__()}(__REQ__(),[__MOM__()=>__OEN__()]);
                                                                        }
                                                                    }
                                                                }
                                                            }

                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if(isset($_SESSION['errors'])){
            unset($_SESSION['errors']);
        }
        return $this->response->setJSON([
            'success' => (bool) $success
        ]);
    }

}