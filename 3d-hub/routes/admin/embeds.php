<?php
$controller = 'General\EmbedController@';
$route = 'admin.embeds';

// manager_routes($controller, $route, true);

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('/',                               $controller.'showEmbeds'               )->name($route);
$route.='.';
Route::get('/list.html',                      $controller.'showEmbeds'               )->name($route.'list');
Route::get('/detail/{id?}',                   $controller.'getResourceDetail'        )->name($route.'detail');
Route::post('/sort',                          $controller.'sort'                     )->name($route.'sort');
Route::post('/save',                          $controller.'save'                     )->name($route.'save');
Route::post('ajax-save',                      $controller.'ajaxSave'                 )->name($route.'ajax-save');
Route::post('/delete',                        $controller.'delete'                   )->name($route.'delete');