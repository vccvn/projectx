<?php
use Illuminate\Support\Facades\Route;

$controller = 'Business\ClientController@';
$route = 'clients';

$listRoute = ['index', 'list', 'create', 'update', 'save', 'delete'];

add_web_module_routes($controller, $listRoute, $route, 'admin');
$route = 'admin.'.$route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('/options',                       $controller.'getSelectOptions'          )->name($route.'select-options');

Route::prefix('feedback')->group(function(){
    
    $controller = 'Business\ClientFeedbackController@';
    $route = 'clients.feedback';

    $listRoute = ['index', 'list', 'create', 'update', 'save', 'delete'];

    add_web_module_routes($controller, $listRoute, $route, 'admin');
    $route = 'admin.'.$route.'.';
    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */

    Route::get('/options',                       $controller.'getSelectOptions'          )->name($route.'select-options');

});