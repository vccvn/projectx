<?php

use Illuminate\Support\Facades\Route;

$controller = 'ConfigController@';
$route = 'config';

$listRoute = ['index'];

add_web_module_routes($controller, $listRoute, $route);

$route.='.';


/**
 * --------------------------------------------------------------------------------------------------------------------
 * |                    URI                    |       Controller @ method       |             Route Name             |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::post('/',                               $controller.'saveWPConfig'         )->name($route.'save');
