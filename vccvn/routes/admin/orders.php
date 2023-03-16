<?php
use Illuminate\Support\Facades\Route;

$controller = 'Ecommerce\OrderController@';
$route = 'orders';
admin_routes($controller, $route, true);
$route = 'admin.'.$route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/get-product-input',             $controller.'getProductInput'           )->name($route.'get-product-input');
Route::get('/list/{list}.html',              $controller.'getListByStatus'           )->name($route.'list-by-status');
Route::post('/change-status',                $controller.'changeStatus'              )->name($route.'change-status');
Route::get('/detail',                        $controller.'getOrderDetail'            )->name($route.'resource-detail');
Route::get('/options',                       $controller.'getSelectOptions'          )->name($route.'select-options');


/*
 *----------------------------------------------------------------------------
 *            Nơi dành cho feedback
 *----------------------------------------------------------------------------
 */

Route::prefix('feedback')->group(function () {
    $controller = 'Ecommerce\OrderFeedbackController@';
    $route = 'orders.feedback';

    admin_routes($controller, $route, true);
    $route = 'admin.'.$route.'.';

    /**
     * --------------------------------------------------------------------------------------------------------------------
     *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
     * --------------------------------------------------------------------------------------------------------------------
     */
    Route::get('/detail',                        $controller.'getFeedbackDetail'            )->name($route.'resource-detail');
    Route::post('/resolve',                      $controller.'resolve'                      )->name($route.'resolve');
    Route::post('/unresolve',                    $controller.'unresolve'                    )->name($route.'unresolve');
});
