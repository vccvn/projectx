<?php
$controller = 'General\ComponentController@';
$route = 'admin.components';

// manager_routes($controller, $route, true);

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('/',                               $controller.'showComponents'           )->name($route);
$route.='.';
Route::get('/list.html',                      $controller.'showComponents'           )->name($route.'list');
Route::get('/detail/{id?}',                   $controller.'getComponentDetail'       )->name($route.'detail');
Route::post('/sort',                          $controller.'sort'                     )->name($route.'sort');
Route::post('/save',                          $controller.'save'                     )->name($route.'save');
Route::post('ajax-save',                      $controller.'ajaxSave'                 )->name($route.'ajax-save');
Route::post('/delete',                        $controller.'delete'                   )->name($route.'delete');

Route::match(['get', 'post'], '/inputs',      $controller.'getComponentInputs'       )->name($route.'inputs');
