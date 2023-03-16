<?php
use Illuminate\Support\Facades\Route;
$controller = 'Personal\AcademicController@';
$route = 'admin.academics';

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

$route.='.';
Route::get('/options',                       $controller.'getSelectOptions'          )->name($route.'select-options');
Route::post('/add',                          $controller.'add'                       )->name($route.'add');
