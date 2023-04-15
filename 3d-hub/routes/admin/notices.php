<?php
$controller = 'General\NoticeController@';
$route = 'admin.notices';

// manager_routes($controller, $route, true);
$route.='.';

/**
 * --------------------------------------------------------------------------------------------------------------------
 * |                    URI                    |       Controller @ method       |             Route Name             |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('get-user-notices',                  $controller.'getUserNotices'     )->name($route.'get-json');