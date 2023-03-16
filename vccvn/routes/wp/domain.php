<?php

use Illuminate\Support\Facades\Route;

$controller = 'DomainController@';
$route = 'domain';

$listRoute = ['index'];

// add_web_module_routes($controller, $listRoute, $route);


/**
 * --------------------------------------------------------------------------------------------------------------------
 * |                    URI                    |       Controller @ method       |             Route Name             |
 * --------------------------------------------------------------------------------------------------------------------
 */


Route::get('/',                                $controller.'index'                     )->name($route);

$route.='.';

// Route::post('create',                          $controller.'createDatabase'          )->name($route.'create');
// Route::post('get-password',                    $controller.'getPassword'             )->name($route.'get-password');


Route::post('/save',                           $controller.'handle'                            )->name($route.'save');