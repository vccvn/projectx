<?php

use Illuminate\Support\Facades\Route;

$controller = 'General\PageController@';
$route = 'pages';
admin_routes($controller, $route, true);
$route = 'admin.'.$route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
// Route::get('/parent-options',                 $controller.'getParentSelectOptions'   )->name($route.'parent-option');
// Route::get('/user-tag-data',                  $controller.'getUserTagData'           )->name($route.'tag-data');

Route::post('/check-slug',                   $controller.'checkSlug'                )->name($route.'check-slug');
Route::get('/get-slug',                      $controller.'getSlug'                  )->name($route.'get-slug');
