<?php

use Illuminate\Support\Facades\Route;

Route::prefix('methods')->group(function () {
    $controller = 'PaymentMethodController@';
    manager_routes($controller, 'payments.methods', true);
    $route = 'payments.methods.';
    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                             | Controller @ Nethod                  | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::post('/inputs',                         $controller.'getMethodInputs'          )->name($route.'inputs');
    Route::post('/ajax-save',                      $controller.'ajaxSave'                 )->name($route.'ajax.save');
    Route::post('/update-status',                  $controller.'updateStatus'             )->name($route.'ajax.update-status');
    Route::get('/ajax-detail',                     $controller.'getMethodDetail'          )->name($route.'ajax.detail');
    Route::post('/update-priority',                $controller.'updatePriority'           )->name($route.'ajax.update-priority');
    
});
