<?php

$controller = 'General\UserController@';
$route = 'users';
admin_routes($controller, $route, true);
$route = 'admin.'.$route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/user-select-options',            $controller.'getUserSelectOptions'     )->name($route.'select-option');
Route::get('/user-tag-data',                  $controller.'getUserTagData'           )->name($route.'tag-data');

