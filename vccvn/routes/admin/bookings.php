<?php
use Illuminate\Support\Facades\Route;

$controller = 'General\BookingController@';
$route = 'bookings';
admin_routes($controller, $route, true);
$route = 'admin.'.$route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
// Route::get('/parent-options',                 $controller.'getParentSelectOptions'   )->name($route.'parent-option');
// Route::get('/user-tag-data',                  $controller.'getUserTagData'           )->name($route.'tag-data');

