<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */




$routes->get('/', 'Home::index'); // Default controller
$routes->get('search', 'Home::search');
$routes->get('newsearch', 'Home::newsearch');
$routes->post('seatselection', 'Home::seatselection');
$routes->get('fillinfo', 'Home::fillinfo');
$routes->post('midform', 'Home::midform');
$routes->get('login', 'Home::login');
$routes->post('login','Home::login');
$routes->get('logout', 'Home::logout');
$routes->post('newreg', 'Home::newreg');
// $routes->get('slogin', 'Home::slogin');
// $routes->get('register', 'Home::register');
$routes->post('payment', 'Home::payment');
$routes->post('process_payment', 'Home::process_payment');

$routes->get('profile', 'Personal::profile');
$routes->get('tickets', 'Personal::tickets');
$routes->get('refund', 'Personal::refund');
$routes->get('tickets/print', 'Personal::print_ticket');
$routes->get('tickets/cancel_ticket', 'Personal::cancel_ticket');

// Admin Routes
$routes->get('admin', 'Admin::index'); // Assuming 'admin' is a controller
$routes->post('admin/auth', 'Admin::auth'); // Assuming 'admin' is a controller
$routes->get('admin/register','Admin::register');
$routes->get('admin/logout','Admin::logout');
$routes->post('admin/register','Admin::register');

// Dashboard Routes
$routes->get('dashboard', 'Dashboard::index');

// District Routes
$routes->get('district', 'District::index');
$routes->post('dashboard/odtbaseonroi', 'District::route_info');

// Company Routes
$routes->get('dashboard/company', 'Dashboard::company');
$routes->post('dashboard/company', 'Dashboard::company');
$routes->get('dashboard/company_edit_info', 'Dashboard::company_edit');
$routes->post('dashboard/update_company', 'Dashboard::update_company'); // Use post for updates
$routes->get('dashboard/delete_company', 'Dashboard::delete_company');
$routes->get('dashboard/company_info', 'Dashboard::company_info');



// Routes Routes
$routes->get('dashboard/routes', 'Routes::index');
$routes->post('dashboard/create_route', 'Routes::create_route');
$routes->get('dashboard/delete_route', 'Routes::del_route');
$routes->get('dashboard/delete_w_route', 'Routes::del_w_route');
$routes->get('dashboard/list_route', 'Routes::list_route');
$routes->get('dashboard/list_route2', 'Routes::list_route2');
$routes->get('dashboard/view_full_route', 'Routes::view_full_route');
$routes->get('dashboard/route_edit_info', 'Routes::route_edit');
$routes->post('dashboard/update_route_info', 'Routes::up_route');  // Use post for updates
$routes->post('dashboard/update_route', 'Routes::update_route'); // Use post for updates

// Ticket Routes
$routes->get('dashboard/ticket', 'Dashboard::ticket');
$routes->get('dashboard/refund', 'Dashboard::refund');
$routes->post('dashboard/sendref', 'Dashboard::sendref'); // Use post for sending refunds

// Trip Routes
$routes->get('dashboard/trip', 'Trip::index');
$routes->post('dashboard/create_trip', 'Trip::create_trip');
$routes->get('dashboard/cancel_trip', 'Trip::cancel_trip');
$routes->get('dashboard/list_trip', 'Trip::list_trip');
$routes->get('dashboard/clist_trip', 'Trip::clist_trip');
$routes->get('dashboard/view_trip_info', 'Trip::view_trip_info');
$routes->get('dashboard/print_trip_info', 'Trip::print_trip_info');

// Coach Routes
$routes->get('dashboard/coach', 'Coach::index');
$routes->get('dashboard/coach_info', 'Coach::coach_info');
$routes->get('dashboard/list_coach', 'Coach::list_coach');
$routes->post('dashboard/create_coach', 'Coach::create_coach');
$routes->post('dashboard/update_coach', 'Coach::update_coach'); // Use post for updates
$routes->get('dashboard/view_coach_info', 'Coach::view_coach_info');
$routes->get('dashboard/delete_coach', 'Coach::delete_coach');




$routes->setDefaultNamespace('App\Controllers'); // Important: Set your controller namespace
$routes->setDefaultController('Home'); // Set the default controller
$routes->setDefaultMethod('index'); // Set the default method

$routes->setTranslateURIDashes(false); // Same as before

// 404 Override (if needed)
//$routes->set404Override(function() {
//    echo "404 - Page Not Found";
//});