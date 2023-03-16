<?php

// controller

use Illuminate\Support\Facades\Route;

$c = 'Admin\Controller@';
$r = 'api.admin';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/    
$c = 'Admin\AccountController@';


Route::prefix('accounts')->group(function () {
    $controller = 'Admin\AccountController@';
    $route = 'admin.accounts';

    // admin_routes($controller, $route, true);
    $route = 'api.'.$route.'.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::post('check',                          $controller.'checkData'                )->name($route.'check');
    Route::post('create',                         $controller.'create'                   )->name($route.'create');
    Route::post('upgrade',                        $controller.'upgrade'                  )->name($route.'upgrade');
    
});