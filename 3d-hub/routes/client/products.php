<?php

$c = 'ProductController@';
$r = 'client.products';
/**
 * -------------------------------------------------------------------------------------------------------------------------------
 *  Method | URI                                           | Controller @ Nethod         | Route Name               
 * -------------------------------------------------------------------------------------------------------------------------------
 */

Route::get('/san-pham/',                                    $c.'viewProducts'            )->name($r);$r.='.';
$prefix = '/danh-muc/';
Route::get($prefix,                                         $c.'viewProducts'            )->name($r.'categories.view-by-id');
Route::get($prefix.'{slug}.html',                           $c.'viewProducts'            )->name($r.'categories.view-simple');
Route::get($prefix.'{parent}/{child}.html',                 $c.'viewProducts'            )->name($r.'categories.view-child');
Route::get($prefix.'{first}/{second}/{third}.html',         $c.'viewProducts'            )->name($r.'categories.view-3-level');
Route::get($prefix.'{first}/{second}/{third}/{fourth}.html',$c.'viewProducts'            )->name($r.'categories.view-4-level');
Route::get('/san-pham/{slug}.html',                         $c.'viewProductDetail'       )->name($r.'detail');
Route::get('/san-pham/{slug}.json',                         $c.'getProductJsonData'      )->name($r.'json');
Route::get('/products/detail/{id?}',                        $c.'getProductJsonData'      )->name($r.'data');
Route::post('san-pham/kiem-tra-gia',                        $c.'checkPrice'              )->name($r.'check-price');

Route::post('san-pham/danh-gia',                            $c.'makeReview'              )->name($r.'review');
Route::post('san-pham/gui-danh-gia-bang-ajax',              $c.'ajaxMakeReview'          )->name($r.'ajax-review');
