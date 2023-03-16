<?php

Route::prefix('attributes')->group(function () {
    $controller = 'ProductAttributeController@';
    $route = 'api.products.attributes';
    
        api_routes($controller, $route, true);
        $route .= '.';
    

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */



    Route::prefix('values')->group(function () {
        $controller = 'ProductAttributeValueController@';
        $route = 'api.products.attributes.values';
    
        api_routes($controller, $route, true);
        $route .= '.';
    
        /**
         * ----------------------------------------------------------------------------------------------------------------
         *    Method | URI                       | Controller @ Nethod                   | Route Name                     |
         * ----------------------------------------------------------------------------------------------------------------
         */
    });
});