<?php

$controller = 'General\AccountController@';
$route = 'account';
$route = 'admin.'.$route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/',                               $controller.'getInfoForm'              )->name('admin.account');
Route::get('/info',                           $controller.'getInfoForm'              )->name($route.'info');
Route::post('/info',                          $controller.'saveInfo');
Route::get('/security',                       $controller.'getSecurityForm'          )->name($route.'security');
Route::post('/security',                      $controller.'saveSecurity');

