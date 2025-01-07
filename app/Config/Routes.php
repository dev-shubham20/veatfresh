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
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/cart', 'Cart::index');
$routes->get('/wishlist', 'Wishlist::index');
$routes->get('/terms-and-conditions', 'Home::terms');
$routes->get('/privacy-policy', 'Home::privacy');
$routes->get('/contact', 'Home::contactus');
$routes->get('/about', 'Home::about');
$routes->get('/faq', 'Home::faq');
$routes->get('/product-detail/(:any)', 'Product::product_detail/$1');
$routes->get('/shop', 'Product::all_products');
$routes->get('/category/(:any)', 'Product::products_by_category/$1');
$routes->get('/login', 'Home::login');
$routes->get('/logout', 'Home::logout');
$routes->get('/register', 'Home::register');
$routes->get('/search', 'Home::search_result');
$routes->get('/account', 'Home::my_account');
$routes->get('/changepassword', 'Home::change_password');
$routes->get('/track-order', 'Home::track_order');
$routes->get('/order-detail/(:any)', 'Home::order_detail/$1');
$routes->get('/checkout', 'Checkout::index');
$routes->get('/refer-and-earn', 'Home::refer_and_earn');

$routes->get('/forgot-password', 'Home::forgot_password');

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
