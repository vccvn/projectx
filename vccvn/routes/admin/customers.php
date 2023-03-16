<?php
use Illuminate\Support\Facades\Route;

$controller = 'Ecommerce\CustomerController@';
$route = 'customers';
admin_routes($controller, $route, true);
$route = 'admin.'.$route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('/options',                       $controller.'getSelectOptions'          )->name($route.'select-options');
