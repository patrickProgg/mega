<?php
defined('BASEPATH') or exit('No direct script access allowed');


// $route['default_controller'] = 'Login_controller';
// $route['dashboard'] = 'Dashboard_controller/index';
// $route['index'] = 'User_controller/index';
// $route['login'] = 'login_controller/login';
// $route['logout'] = 'login_controller/logout';
// $route['authenticate'] = 'login_controller/authenticate';

$route['default_controller'] = 'dashboard';
$route['dashboard'] = 'Dashboard_ctrl/index';
$route['index'] = 'User_ctrl/index';
$route['payment'] = 'Payment_ctrl/index';
$route['rental'] = 'Rental_ctrl/index';
$route['history'] = 'History_ctrl/index';
$route['loan'] = 'Loan_ctrl/index';
$route['login'] = 'Login_ctrl/login';  
$route['logout'] = 'Login_ctrl/logout';
// $route['profile'] = 'Dashboard_controller/profile';
$route['authenticate'] = 'Login_ctrl/authenticate';


// $route['upload'] = 'Dashboard_controller/upload';





$route['404_override'] = '';             // Default 404 page
$route['translate_uri_dashes'] = FALSE; // Preserve dashes in URL segments
