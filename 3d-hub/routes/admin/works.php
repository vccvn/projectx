<?php
$controller = 'Personal\WorkController@';
$route = 'admin.works';

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

$route.='.';
Route::get('/options',                       $controller.'getSelectOptions'          )->name($route.'select-options');
Route::post('/add',                          $controller.'add'                       )->name($route.'add');
