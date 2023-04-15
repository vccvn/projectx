<?php
Route::prefix('modules')->group(function () {
    $controller = 'PermissionModuleController@';
    $route = 'permissions.modules';

    manager_routes($controller, $route, true);
    $route .= '.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::get('/get-route-options',                      $controller.'getRouteOptions'          )->name($route.'get-route-options');
            
    
});


Route::prefix('roles')->group(function () {
    $controller = 'PermissionRoleController@';
    $route = 'permissions.roles';

    manager_routes($controller, $route, true);
    $route .= '.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */

     Route::post('save-user-role',               $controller.'saveUserRole'              )->name($route.'save-user-role');


    
});