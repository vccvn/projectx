<?php

use Illuminate\Support\Facades\Route;

$controller = 'PackageController@';
$route = 'packages';
// manager_routes($controller, $route, true);
$route.='.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/',                               $controller.'getInfo'                  )->name($route.'index');
Route::post('/upgrade',                       $controller.'upgrade'                  )->name($route.'upgrade');

