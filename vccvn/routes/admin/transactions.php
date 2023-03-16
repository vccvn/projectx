<?php
use Illuminate\Support\Facades\Route;
Route::prefix('orders')->group(function () {
    $controller = 'Ecommerce\OrderTransactionController@';
    $route = 'transactions.orders';


    // $listRoute = ['index', 'list', 'trash', 'create', 'update', 'save', 'move-to-trash', 'delete'];

    add_web_module_routes($controller, '*', $route, 'admin');
    $route = 'admin.'.$route.'.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::get('/detail',                        $controller.'getTransactionDetail'         )->name($route.'resource-detail');
    Route::post('/status/{slug}',                $controller.'changeStatus'              )->name($route.'status');

    
    
});