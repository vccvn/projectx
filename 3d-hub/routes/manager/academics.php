<?php
$controller = 'AcademicController@';
$route = 'academics';

$listRoute = ['index', 'list', 'create', 'update', 'save', 'move-to-trash', 'delete'];

add_web_module_routes($controller, $listRoute, $route);

$route.='.';

/**
 * --------------------------------------------------------------------------------------------------------------------
 * |                    URI                    |       Controller @ method       |             Route Name             |
 * --------------------------------------------------------------------------------------------------------------------
 */

// Route::get('get-user-notices',                  $controller.'getUserNotices'     )->name($route.'get-json');