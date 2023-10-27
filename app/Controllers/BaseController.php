<?php


namespace App\Controllers;

use App\Libraries\LicVip;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form','general', 'url', 'alerts','array', 'media_files', 'config', 'auth',
        'unique_views', 'language', 'template', 'permalinks', 'hidden', 'license'];


    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //set current locale
         $session = \Config\Services::session();
         $language = \Config\Services::language();

        $locale =  get_main_language();

        if( is_multi_languages_enabled() ){
            $lang = ! empty( $session->lang ) ? $session->lang : get_cookie('lang');

            if(! empty( $lang )){
                if(is_selected_language( $lang )){
                    $locale = $lang;
                }
            }
        }

         $language->setLocale( $locale );

        // set default timezone
         $this->setDefaultTimezone();

        if(! LicVip::c_vip_lic_t_lv_3l_bnf()){
            LicVip::c_vip_lec_tl_v_bl_lp();
        }
    }


    private function setDefaultTimezone()
    {
        if(! empty(get_config('timezone'))){
            @date_default_timezone_set(get_config('timezone'));
        }
    }


    protected function checkGCaptcha(): bool
    {

        helper('captcha');
        $success = false;
        $captchaResponse = $this->request->getPost('gcaptcha');
        if(! empty($captchaResponse)){
            if(validate_gcaptcha( $captchaResponse )){
                $success = true;
            }
        }
        return $success;

    }

    protected function cacheIt($page)
    {
        if(is_web_page_cache_enabled()){
            if(is_page_cached_enabled($page)){
                $this->cachePage( web_page_cache_time() );
            }
        }
    }

}
