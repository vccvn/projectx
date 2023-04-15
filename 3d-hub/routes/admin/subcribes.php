<?php

$controller = 'General\SubcribeController@';

$route = 'subcribes';

$listRoute = ['index', 'list', 'create', 'update', 'save', 'delete'];

add_web_module_routes($controller, $listRoute, $route, 'admin');

$route = 'admin.'.$route.'.';

/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
