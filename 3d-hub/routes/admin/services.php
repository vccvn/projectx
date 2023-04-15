<?php

use Illuminate\Support\Facades\Route;

$controller = 'Business\ServiceController@';
$route = 'services';

$listRoute = ['index', 'list', 'trash', 'create', 'update', 'save', 'move-to-trash', 'restore', 'delete'];

add_web_module_routes($controller, $listRoute, $route, 'admin');
$route = 'admin.'.$route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('/options',                       $controller.'getSelectOptions'          )->name($route.'select-options');

Route::prefix('user-services')->group(function(){
    $controller = 'Business\UserServiceController@';
    $route = 'services.users';
    
    $listRoute = ['index', 'list', 'trash', 'create', 'update', 'save', 'move-to-trash', 'restore', 'delete'];
    
    add_web_module_routes($controller, $listRoute, $route, 'admin');
    $route = 'admin.'.$route.'.';
        

});