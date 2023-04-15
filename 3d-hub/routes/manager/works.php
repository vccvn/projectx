<?php
$controller = 'WorkController@';
$route = 'works';

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

manager_routes($controller, $route, true);
$route.='.';
Route::get('/options',                       $controller.'getSelectOptions'          )->name($route.'select-options');
Route::post('/add',                          $controller.'add'                       )->name($route.'add');
