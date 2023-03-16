<?php

use Illuminate\Support\Facades\Route;

$controller = 'PackageController@';
$route = 'packages';
manager_routes($controller, $route, true);
$route.='.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
// Route::get('/user-select-options',            $controller.'getUserSelectOptions'     )->name($route.'select-option');

