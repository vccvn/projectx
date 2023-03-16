<?php

use Illuminate\Support\Facades\Route;

Route::prefix('packages')->group(function () {
    $controller = 'PackagePaymentTransactionController@';
    $route = 'transactions.packages';


    // $listRoute = ['index', 'list', 'trash', 'create', 'update', 'save', 'move-to-trash', 'delete'];

    add_web_module_routes($controller, '*', $route);
    $route = $route.'.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::get('/detail',                        $controller.'getTransactionDetail'      )->name($route.'resource-detail');
    Route::post('/status/{slug}',                $controller.'changeStatus'              )->name($route.'status');
    
});