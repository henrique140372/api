<?php

namespace Config;

use App\Filters\AdminAccessPermission;
use App\Filters\AjaxFilter;
use App\Filters\Auth;
use App\Filters\DownloadLinksThrottle;
use App\Filters\EmbedFirewall;
use App\Filters\LinksReportThrottle;
use App\Filters\LoadUser;
use App\Filters\LoggedUserAccessDenied;
use App\Filters\AdminModAccessPermission;
use App\Filters\MoviesRequestThrottle;
use App\Filters\StreamLinksThrottle;
use App\Filters\UserAccessPermission;
use App\Filters\VideoPlayedThrottle;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array
     */
    public $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'ajax' => AjaxFilter::class,
        'embedfirewall' => EmbedFirewall::class,
        'links_reports_throttle' => LinksReportThrottle::class,
        'stream_links_throttle' => StreamLinksThrottle::class,
        'download_links_throttle' => DownloadLinksThrottle::class,
        'movies_request_throttle' => MoviesRequestThrottle::class,
        'videos_played_throttle' => VideoPlayedThrottle::class,
        'auth' => Auth::class,
        'load_logged_user' => LoadUser::class,
        'logged_user_access_denied' => LoggedUserAccessDenied::class,
        'admin_access' => AdminAccessPermission::class,
        'user_access' => UserAccessPermission::class,
        'admin_and_moderator_access' => AdminModAccessPermission::class
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array
     */
    public $globals = [
        'before' => [
            'load_logged_user'
            // 'honeypot',
            // 'csrf',
            // 'invalidchars',
        ],
        'after' => [
            'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['csrf', 'throttle']
     *
     * @var array
     */
    public $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     *
     * @var array
     */
    public $filters = [
        'ajax' => [
           //'before' => ['admin/ajax/*', 'ajax/*']
        ],
        'csrf' => [
            'before' => [
                'request/create',
                'user/links/create/*',
                'login/check',
                'register/create',
                'contact-us/submit',
            ]
        ],
        'embedfirewall' => [
            'before' => ['embed/*']
        ],
        'movies_request_throttle' => [
            'before' => ['request/create']
        ],
        'links_reports_throttle' => [
            'before' => ['ajax/report_download_links', 'ajax/report_stream_link']
        ],
        'download_links_throttle' => [
            'before' => ['link/*']
        ],
        'stream_links_throttle' => [
            'before' => ['ajax/get_stream_link']
        ],
        'videos_played_throttle' => [
            'before' => ['ajax/played']
        ],
        'auth' => [
            'before' => ['admin/*', 'user/*']
        ],
        'logged_user_access_denied' => [
            'before' => ['login','login/*', 'register', 'register/*']
        ],
        'admin_and_moderator_access' => ['before' => [  'admin/*' ] ],
        'admin_access' => [
            'before' => [
                'admin/movies/delete/*',
                'admin/movies/bulk_delete',
                'admin/movies/bulk_delete/*',
                'admin/links/bulk_delete',
                'admin/links/bulk_delete/*',
                'admin/series/delete/*',
                'admin/series/bulk_delete',
                'admin/series/bulk_delete/*',
                'admin/users',
                'admin/users/*',
                'admin/genres',
                'admin/genres/*',
                'admin/statistics/*',
                'admin/ads/*',
                'admin/pages',
                'admin/pages/*',
                'admin/third-party-apis',
                'admin/third-party-apis/*',
                'admin/settings/*',
            ]
        ],
        'user_access' => [
            'before' => ['user/*']
        ]

    ];
}
