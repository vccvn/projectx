<?php
use Illuminate\Support\Facades\Route;

$controller = 'AccountController@';
$route = 'account.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/',                               $controller.'getInfoForm'              )->name('account');
Route::get('/info',                           $controller.'getInfoForm'              )->name($route.'info');
Route::post('/info',                          $controller.'saveInfo');
Route::get('/security',                       $controller.'getSecurityForm'          )->name($route.'security');
Route::post('/security',                      $controller.'saveSecurity');

