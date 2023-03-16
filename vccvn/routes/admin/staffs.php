<?php
use Illuminate\Support\Facades\Route;

$controller = 'General\StaffController@';
$route = 'staffs';
admin_routes($controller, $route, true);
$route = 'admin.'.$route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/user-select-options',            $controller.'getUserSelectOptions'     )->name($route.'select-options');
Route::get('/user-tag-data',                  $controller.'getUserTagData'           )->name($route.'tag-data');

