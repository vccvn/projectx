<?php
use Illuminate\Support\Facades\Route;
$controller = 'General\ThemeController@';

$route = 'admin.themes';

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('/',                              $controller.'getPublishThemes'          )->name($route);
$route.='.';
Route::get('/store.html',                    $controller.'getPublishThemes'          )->name($route.'store');
Route::get('/my-themes.html',                $controller.'getMyThemes'               )->name($route.'my-themes');

Route::get('options.html',                   $controller.'getThemeOptionForm'        )->name($route.'options');
Route::get('options/{group}.html',           $controller.'getThemeOptionForm'        )->name($route.'options.group');
Route::post('options/{group}',               $controller.'saveThemeOption'           )->name($route.'options.group.save');

// Route::get('options',                        $controller.'getSelectOptions'          )->name($route.'select-options');
Route::get('detail/{id?}',                   $controller.'getResourceDetail'         )->name($route.'detail');
Route::get('my-detail/{id?}',                $controller.'getMyThemeDetail'          )->name($route.'my-detail');
Route::get('search',                         $controller.'ajaxSearch'                )->name($route.'search');
Route::get('my-themes',                      $controller.'ajaxSearchMyThemes'        )->name($route.'search-my-themes');
Route::post('active',                        $controller.'active'                    )->name($route.'active');
Route::get('test-active',                    $controller.'active'                    )->name($route.'test-active');

$listRoute = ['create', 'update', 'save', 'delete'];

add_web_module_routes($controller, $listRoute, 'themes', 'admin');
