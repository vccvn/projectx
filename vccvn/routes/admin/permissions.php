<?php
use Illuminate\Support\Facades\Route;
Route::prefix('modules')->group(function () {
    $controller = 'General\PermissionModuleController@';
    $route = 'permissions.modules';

    admin_routes($controller, $route, true);
    $route = 'admin.'.$route.'.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::get('/get-route-options',                      $controller.'getRouteOptions'          )->name($route.'get-route-options');
            
    
});


Route::prefix('roles')->group(function () {
    $controller = 'General\PermissionRoleController@';
    $route = 'permissions.roles';

    admin_routes($controller, $route, true);
    $route = 'admin.'.$route.'.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */

     Route::post('save-user-role',               $controller.'saveUserRole'              )->name($route.'save-user-role');


    
});