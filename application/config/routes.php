<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/




//$route['default_controller'] = 'welcome';
$route['default_controller'] = 'home';
$route['search'] = 'home/search';







$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['admin']='admin';

$route['dashboard']='dashboard';

$route['district']='district';
$route['dashboard/odtbaseonroi']='district/route_info';
/*For Company */
$route['dashboard/company']='dashboard/company';
$route['dashboard/company_edit_info']='dashboard/company_edit';
$route['dashboard/update_company']='dashboard/update_company';
$route['dashboard/delete_company']='dashboard/delete_company';
/* For routes */
$route['dashboard/routes'] = 'routes';
$route['dashboard/create_route'] = 'routes/create_route';
$route['dashboard/delete_route'] = 'routes/del_route';
$route['dashboard/delete_w_route'] = 'routes/del_w_route';
$route['dashboard/list_route'] = 'routes/list_route';
$route['dashboard/list_route2'] = 'routes/list_route2';
$route['dashboard/view_full_route'] = 'routes/view_full_route';
$route['dashboard/route_edit_info'] = 'routes/route_edit';
$route['dashboard/update_route_info'] = 'routes/up_route';
$route['dashboard/update_route'] = 'routes/update_route';


$route['dashboard/trip'] = 'trip';
$route['dashboard/create_trip'] = 'trip/create_trip';
$route['dashboard/list_trip'] = 'trip/list_trip';
$route['dashboard/view_trip_info'] = 'trip/view_trip_info';
$route['dashboard/print_trip_info'] = 'trip/print_trip_info';




$route['dashboard/coach'] = 'coach';
$route['dashboard/coach_info'] = 'coach/coach_info';
$route['dashboard/list_coach'] = 'coach/list_coach';
$route['dashboard/create_coach'] = 'coach/create_coach';
$route['dashboard/update_coach'] = 'coach/update_coach';
$route['dashboard/view_coach_info'] = 'coach/view_coach_info';
$route['dashboard/delete_coach'] = 'coach/delete_coach';




