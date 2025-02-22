<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);

// Default Routes
$routes->get('/', 'Home::index');
$routes->get('search', 'Home::search');
$routes->get('newsearch', 'Home::newsearch');
$routes->post('seatselection', 'Home::seatselection');
$routes->get('fillinfo', 'Home::fillinfo');
$routes->post('midform', 'Home::midform');
$routes->post('payment', 'Home::payment');
$routes->post('process_payment', 'Home::process_payment');

// Authentication Routes
$routes->group('', function ($routes) {
    $routes->get('login', 'Home::login');
    $routes->post('login', 'Home::login');
    $routes->get('logout', 'Home::logout');
    $routes->post('newreg', 'Home::newreg');
});

// User Routes
$routes->group('personal', function ($routes) {
    $routes->get('profile', 'Personal::profile');
    $routes->get('tickets', 'Personal::tickets');
    $routes->get('refund', 'Personal::refund');
    $routes->get('tickets/print', 'Personal::print_ticket');
    $routes->get('tickets/cancel_ticket', 'Personal::cancel_ticket');
});

// Admin Routes
$routes->group('admin', function ($routes) {
    $routes->get('/', 'Admin::index');
    $routes->post('auth', 'Admin::auth');
    $routes->get('register', 'Admin::register');
    $routes->post('register', 'Admin::register');
    $routes->get('logout', 'Admin::logout');
});

// Dashboard Routes
$routes->group('dashboard', function ($routes) {
    $routes->get('/', 'Dashboard::index');
    $routes->get('purchased_tickets/(:segment)', 'Dashboard::purchased_tickets/$1');

    // Company Management
    $routes->group('company', function ($routes) {
        $routes->get('/', 'Dashboard::company');
        $routes->post('/', 'Dashboard::company');
        $routes->get('edit_info', 'Dashboard::company_edit');
        $routes->post('update', 'Dashboard::update_company');
        $routes->get('delete', 'Dashboard::delete_company');
        $routes->get('info', 'Dashboard::company_info');
        $routes->post('users/update', 'Dashboard::update_user'); // Changed to POST after debugging
        $routes->get('users/delete/(:segment)', 'Dashboard::delete_cusers/$1');
        $routes->post('user_info','Dashboard::user_info');
        $routes->get('users/(:segment)', 'Dashboard::cusers/$1');
        $routes->post('users/(:segment)', 'Dashboard::cusers/$1');
   
    });

    // Route Management
    $routes->group('routes', function ($routes) {
        $routes->get('/', 'Routes::index');
        $routes->post('create', 'Routes::create_route');
        $routes->get('delete', 'Routes::del_route');
        $routes->get('delete_w_route', 'Routes::del_w_route');
        $routes->get('list', 'Routes::list_route');
        $routes->get('list2', 'Routes::list_route2');
        $routes->get('view_full', 'Routes::view_full_route');
        $routes->get('edit_info', 'Routes::route_edit');
        $routes->post('update_info', 'Routes::up_route');
        $routes->post('update', 'Routes::update_route');
    });

    // Ticket Management
    $routes->group('ticket', function ($routes) {
        $routes->get('/', 'Dashboard::ticket');
        $routes->get('refund', 'Dashboard::refund');
        $routes->get('sendref', 'Dashboard::sendref');
    });

    // Trip Management
    $routes->group('trip', function ($routes) {
        $routes->get('/', 'Trip::index');
        $routes->post('create', 'Trip::create_trip');
        $routes->get('cancel', 'Trip::cancel_trip');
        $routes->get('list', 'Trip::list_trip');
        $routes->get('clist', 'Trip::clist_trip');
        $routes->get('view_info', 'Trip::view_trip_info');
        $routes->get('print_info', 'Trip::print_trip_info');
    });

    // Coach Management
    $routes->group('coach', function ($routes) {
        $routes->get('/', 'Coach::index');
        $routes->get('info', 'Coach::coach_info');
        $routes->get('list', 'Coach::list_coach');
        $routes->post('create', 'Coach::create_coach');
        $routes->post('update', 'Coach::update_coach');
        $routes->get('view_info', 'Coach::view_coach_info');
        $routes->get('delete', 'Coach::delete_coach');
    });
});

// District Routes
$routes->group('district', function ($routes) {
    $routes->get('/', 'District::index');
    $routes->post('odtbaseonroi', 'District::route_info');
    $routes->get('route_ids', 'District::route_ids');
});

// 404 Override (if needed)
//$routes->set404Override(function() {
//    echo "404 - Page Not Found";
//});
