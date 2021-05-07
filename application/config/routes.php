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
|	https://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//$route['sistem/role-access/(:num)'] = 'sistem/roleaccess/$1';

$route['dashboard/sistem/aplikasi'] = 'dashboard/sistem_aplikasi';
$route['dashboard/sistem/menu'] = 'dashboard/sistem_menu';
$route['dashboard/sistem/menu/urutan'] = 'dashboard/sisten/sistem_urutan_menu';
$route['dashboard/sistem/submenu'] = 'dashboard/sistem_submenu';
$route['dashboard/sistem/role'] = 'dashboard/sistem_role';



$route['dashboard/master'] = 'dashboard/master_index';
$route['dashboard/master/user'] = 'dashboard/master_user';
$route['dashboard/master/category'] = 'dashboard/master_category';



$route['dashboard/product'] = 'dashboard/product_index';
$route['dashboard/product/add'] = 'dashboard/product_add';
$route['dashboard/product/edit/(:num)'] = 'dashboard/product_edit/$1';
$route['dashboard/product/detail/(:any)'] = 'dashboard/product_detail/$1';


$route['dashboard/transaction'] = 'dashboard/transaction_index';
$route['dashboard/transaction/(:any)'] = 'dashboard/transaction_detail/$1';

$route['user/ganti-password'] = 'user/changepw';
$route['lupa-password'] = 'register/forgotpw';
$route['logout'] = 'login/logout';
$route['master'] = 'more/master';
$route['sistem'] = 'more/sistem';
$route['category'] = 'home/redirect';
$route['pay'] = 'home/redirect';
$route['home'] = 'home/redirect';
$route['profile'] = 'home/profile';
$route['profile/edit'] = 'home/profile_edit';
$route['myorder'] = 'home/myorder';
$route['myorder/(:any)'] = 'home/detail_order/$1';
$route['pay/(:any)'] = 'home/pay/$1';
$route['category/(:any)'] = 'home/category/$1';
$route['product/(:any)'] = 'home/product/$1';



/*

// ROUTE AJAX
$route['ajax/role'] = 'role/ajaxList';
$route['ajax/role/add'] = 'role/ajax_add';
$route['ajax/role/update'] = 'role/ajax_update';
$route['ajax/role/edit/(:num)'] = 'role/ajax_edit/$1';
$route['ajax/role/delete/(:num)'] = 'role/ajax_delete/$1';

*/