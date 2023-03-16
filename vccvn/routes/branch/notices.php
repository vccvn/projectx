<?php

use Illuminate\Support\Facades\Route;

$controller = 'NoticeController@';
$route = 'notices';

manager_routes($controller, $route, true);
$route.='.';

/**
 * --------------------------------------------------------------------------------------------------------------------
 * |                    URI                    |       Controller @ method       |             Route Name             |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('get-user-notices',                  $controller.'getUserNotices'     )->name($route.'get-json');