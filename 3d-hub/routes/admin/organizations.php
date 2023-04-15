<?php
$controller = 'Personal\OrganizationController@';
$route = 'admin.organizations';

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

$route.='.';
Route::get('/options',                       $controller.'getSelectOptions'          )->name($route.'select-options');
Route::post('/add',                          $controller.'add'                       )->name($route.'add');
