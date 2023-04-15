<?php

$controller = 'General\ContactController@';
$route = 'contacts';

$listRoute = ['index', 'list', 'create', 'update', 'save', 'delete'];

add_web_module_routes($controller, $listRoute, $route, 'admin');
$route = 'admin.'.$route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('detail',                         $controller.'getResourceDetail'         )->name($route.'detail');


// member
$controller = 'General\ContactReplyController@';
$r = $route.'replies.';
Route::get('replies/detail',                 $controller.'getResourceDetail'         )->name($r.'detail');
Route::post('replies/save',                  $controller.'ajaxSave'                  )->name($r.'save');
Route::post('replies/create',                $controller.'ajaxSave'                  )->name($r.'create');
Route::post('replies/update',                $controller.'ajaxSave'                  )->name($r.'update');
Route::delete('replies/delete',              $controller.'delete'                    )->name($r.'delete');

