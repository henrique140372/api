<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}




/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override(function (){
    helper('template_helper');
    helper('general');
    return view( theme_path('errors/404') );
});
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/lang', 'Language::index');

$routes->get('/earn-money', 'EarnMoney::index');
$routes->get('/contact-us', 'Contact::index');
$routes->post('/contact-us/submit', 'Contact::send_message');

$routes->get('/sitemap\.xml', 'Sitemap::index');
$routes->get('/sitemap/movies/view\.xml', 'Sitemap::get_view_items/movies');
$routes->get('/sitemap/series/view\.xml', 'Sitemap::get_view_items/series');
$routes->get('/sitemap/movies/download\.xml', 'Sitemap::get_dl_items/movie');
$routes->get('/sitemap/series/download\.xml', 'Sitemap::get_dl_items/series');

$routes->get('/sitemap/main\.xml', 'Sitemap::main_pages');
$routes->match(['get','post'], '/reset_password', 'Login::reset_password');



$routes->get('/admin/bulk-import', 'Admin/BulkImport::index');
$routes->get('/admin/stars-log', 'Admin/StarsLog::index');
$routes->get('/admin/next-for-you/delete', 'Admin/FailedMovies::delete');
$routes->get('/admin/next-for-you', 'Admin/FailedMovies::index');
$routes->get('/admin/reported-links', 'Admin/ReportedLinks::index');

$routes->get('/admin/users/links/stream', 'Admin/Links::users_added/stream');
$routes->get('/admin/users/links/direct_dl', 'Admin/Links::users_added/direct_dl');
$routes->get('/admin/users/links/torrent_dl', 'Admin/Links::users_added/torrent_dl');

$routes->get('/admin/links/users-added/stream', 'Admin/Links::users_added/stream');
$routes->get('/admin/links/users-added/direct_dl', 'Admin/Links::users_added/direct_dl');
$routes->get('/admin/links/users-added/torrent_dl', 'Admin/Links::users_added/torrent_dl');

$routes->get('/admin/links/users-added/load_json_data', 'Admin/Links::load_users_added_links_json_data');

$routes->get('/admin/third-party-apis', 'Admin/ThirdPartyApis::index');
$routes->get('/admin/third-party-apis/new', 'Admin/ThirdPartyApis::new');
$routes->get('/admin/third-party-apis/edit', 'Admin/ThirdPartyApis::edit');
$routes->get('/admin/third-party-apis/delete', 'Admin/ThirdPartyApis::delete');


$routes->post('/admin/third-party-apis/create', 'Admin/ThirdPartyApis::create');
$routes->post('/admin/third-party-apis/update', 'Admin/ThirdPartyApis::update');

// MODERATOR ACCESS
$routes->get('/mod/dashboard', 'Admin/Dashboard::index');


$routes->get('/user/my-links', 'User/Links::all_links');
$routes->get('/user/my-movies', 'User/Movies::view_all');
$routes->get('/user/my-shows', 'User/Movies::view_all/series');
$routes->get('/user/earnings', 'User/Withdrawal::index');
$routes->post('/user/earnings/create', 'User/Withdrawal::create_redeem');
$routes->get('/user/earnings/cancel', 'User/Withdrawal::cancel_redeem');
$routes->get('/user/stars-log', 'User/StarsLog::index');
$routes->get('/user/logout', 'Logout::index');


$routes->match(['get','post'], '/admin_login', 'Admin/Login::index');
$routes->addRedirect('/admin', '/admin/dashboard');

$routes->get('/admin/logout', function () {

    //unset session
    session()->remove('is_logged');
    //redirect user
    $redirect = ! empty( $_GET['rd_back'] ) ? previous_url() : '/admin_login';
    return redirect()->to($redirect);

});

//rewrite custom slugs
helper('config');


$routes->get('/' . embed_slug() . '/movie', 'Embed::movie');
$routes->get('/' . embed_slug() . '/series', 'Embed::series');
$routes->get('/' . embed_slug() . '/(:any)', 'Embed::view/$1');

$routes->get('/' . download_slug() . '/movie', 'Download::movie');
$routes->get('/' . download_slug() . '/series', 'Download::series');
$routes->get('/' . download_slug() . '/(:any)', 'Download::view/$1');

$routes->get('/' . view_slug() . '/movie', 'View::movie');
$routes->get('/' . view_slug() . '/series', 'View::series');
$routes->get('/' . view_slug() . '/(:any)', 'View::view/$1');

$routes->get('/p/(:segment)', 'Page::index/$1');

$routes->addRedirect('/imdb-top', '/imdb-top/movies');
$routes->get('/imdb-top/(:segment)', 'Library::imdb_top/$1');

$routes->addRedirect('/trending', '/trending/movies');
$routes->get('/trending/(:segment)', 'Library::trending/$1');

$routes->addRedirect('/recent-releases', '/recent-releases/movies');
$routes->get('/recent-releases/(:segment)', 'Library::recent_releases/$1');

$routes->addRedirect('/history', '/history/movies');
$routes->get('/history/(:segment)', 'Library::history/$1');

$routes->addRedirect('/recommend', '/recommend/movies');
$routes->get('/recommend/(:segment)', 'Library::recommend/$1');


$routes->get('/' . library_slug() . '/movies', 'Library::loadRecord/movies');
$routes->get('/' . library_slug() . '/shows', 'Library::loadRecord/shows');

$routes->post('/' . link_slug() . '/get/(:any)', 'Link::get/$1');
$routes->get('/' . link_slug() . '/(:any)', 'Link::index/$1');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
