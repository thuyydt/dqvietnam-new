<?php
defined('BASEPATH') or exit('No direct script access allowed');
$route['default_controller'] = 'home';
$route['404_override'] = 'page/_404';
$route['translate_uri_dashes'] = FALSE;
$route['sitemap.xml'] = 'seo/sitemap';
$route['admin'] = 'admin/dashboard/index';
$route['admin/account/(:num)'] = 'admin/account/detail';
$route['admin/images/(:any)'] = 'admin/images/index/$1/';

/* Routes public*/
$route['images/(:any)'] = 'admin/images/index/$1/';

$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['register-personal'] = 'auth/register/personal';
$route['register-school'] = 'auth/register/school';
$route['forgot-password'] = 'auth/forgot_password';
$route['payment'] = 'auth/payment';
$route['verify-account'] = 'auth/verify';
$route['packages'] = 'auth/packages';

$route['guide'] = 'guide/step';

$route['hocbai'] = 'game/index';
$route['hocbai/nhiemvu'] = 'game/play';
$route['hocbai/nhiemvu/(:num)'] = 'game/play/$1';
$route['hocbai/review/(:num)'] = 'game/review/$1';
$route['hocbai/training'] = 'game/training';


$route['report'] = 'report/index';
$route['report/detail/(:num)'] = 'report/detail/$1';
$route['dq-la-gi'] = 'page/aboutDq/$1';
$route['nguoi-hung-dq'] = 'page/heroDq/$1';
$route['nha-truong'] = 'page/school/$1';
$route['cha-me'] = 'page/parent/$1';
$route['ho-tro'] = 'page/support/$1';
$route['dieu-khoan-su-dung'] = 'page/terms/$1';
$route['chinh-sach-bao-mat'] = 'page/policy/$1';

/* V2 API Routes */
$route['v2/account']['get'] = 'v2/account/index';
$route['v2/account']['post'] = 'v2/account/create';
$route['v2/account']['put'] = 'v2/account/update';
$route['v2/account']['delete'] = 'v2/account/delete';
$route['v2/account/send-test'] = 'v2/account/sendTest';
$route['v2/account/export'] = 'v2/account/export';
$route['v2/account/payment/(:num)'] = 'v2/account/payment/$1';
$route['v2/account/password'] = 'v2/account/changePassword';
$route['v2/account/(:num)'] = 'v2/account/handle_id/$1';

$route['v2/user']['get'] = 'v2/user/index';
$route['v2/user']['post'] = 'v2/user/create';
$route['v2/user']['put'] = 'v2/user/update';
$route['v2/user']['delete'] = 'v2/user/delete';
$route['v2/user/roles'] = 'v2/user/roles';
$route['v2/user/(:num)'] = 'v2/user/handle_id/$1';

$route['v2/school'] = 'v2/school/index';
$route['v2/school/(:num)'] = 'v2/school/handle_id/$1';

$route['v2/auth/login'] = 'v2/auth/login';
$route['v2/auth/register'] = 'v2/auth/register';
$route['v2/auth/forgot'] = 'v2/auth/forgot';
$route['v2/auth/reset'] = 'v2/auth/reset';
$route['v2/auth/active-payment'] = 'v2/auth/active';
$route['v2/auth/ping'] = 'v2/auth/pingPong';
$route['v2/auth/activities'] = 'v2/auth/handle_activities';

$route['v2/setting']['get'] = 'v2/setting/index';
$route['v2/setting']['post'] = 'v2/setting/store';

$route['v2/activation'] = 'v2/activation/index';
$route['v2/activation/(:num)'] = 'v2/activation/handle_id/$1';

$route['v2/payment'] = 'v2/payment/index';
/* End V2 API Routes */

$route['(:any)'] = 'page/index/$1/';
/* Routes public*/
