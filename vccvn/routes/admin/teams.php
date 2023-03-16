<?php
use Illuminate\Support\Facades\Route;

$controller = 'Business\TeamController@';

$route = 'teams';

$listRoute = ['index', 'list', 'create', 'update', 'save', 'delete'];

add_web_module_routes($controller, $listRoute, $route, 'admin');

$route = 'admin.'.$route.'.';

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('options',                        $controller.'getSelectOptions'          )->name($route.'select-options');
Route::get('detail',                         $controller.'getResourceDetail'         )->name($route.'detail');

// member
$controller = 'Business\TeamMemberController@';
$r = $route.'members.';
Route::get('members/detail',                 $controller.'getResourceDetail'         )->name($r.'detail');
Route::post('members/save',                  $controller.'ajaxSave'                  )->name($r.'save');
Route::post('members/create',                $controller.'ajaxSave'                  )->name($r.'create');
Route::post('members/update',                $controller.'ajaxSave'                  )->name($r.'update');
Route::delete('members/delete',              $controller.'delete'                    )->name($r.'delete');
