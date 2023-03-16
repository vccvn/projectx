<?php

use Illuminate\Support\Facades\Route;

$controller = 'ThemeController@';
$route = 'themes';

manager_routes($controller, $route, true);
$route.='.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('download/{slug}',                 $controller.'download'                 )->name($route.'download');
Route::post('extract',                        $controller.'extract'                  )->name($route.'extract');

