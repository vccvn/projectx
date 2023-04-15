<?php
$controller = 'General\TagController@';
$route = 'admin.tags';

// manager_routes($controller, $route, true);

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('/',                                $controller.'getIndex'                 )->name($route);
$route.='.';
Route::get('/list.html',                       $controller.'getList'                  )->name($route.'list');
Route::get('/data.json',                       $controller.'getData'                  )->name($route.'data');
Route::post('/create-tags',                    $controller.'createTags'               )->name($route.'create');
Route::put('/update',                         $controller.'updateTag'                )->name($route.'update');
Route::post('/delete',                         $controller.'delete'                   )->name($route.'delete');