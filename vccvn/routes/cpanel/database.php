<?php

use Illuminate\Support\Facades\Route;

$controller = 'DatabaseController@';
$route = 'database';

$listRoute = ['index'];

add_web_module_routes($controller, $listRoute, $route);

$route.='.';


/**
 * --------------------------------------------------------------------------------------------------------------------
 * |                    URI                    |       Controller @ method       |             Route Name             |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::post('create',                          $controller.'createDatabase'          )->name($route.'create');
Route::post('get-password',                    $controller.'getPassword'             )->name($route.'get-password');
