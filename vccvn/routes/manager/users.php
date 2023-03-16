<?php

use Illuminate\Support\Facades\Route;

$controller = 'UserController@';
$route = 'users';
manager_routes($controller, $route, true);
$route.='.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/user-select-options',            $controller.'getUserSelectOptions'     )->name($route.'select-option');



Route::post('/expired-extension',             $controller.'extension'                )->name($route.'extension');

