<?php

use Illuminate\Support\Facades\Route;

$o = 'OrderController@';
$c = 'CartController@';
$customer = 'CustomerController@';
$p = 'PaymentController@';
$r = 'client.orders.';
$rp = 'client.payments.';
$rc = 'client.customers.';

/**
 * -------------------------------------------------------------------------------------------------------------------------------
 *  Method | URI                                           | Controller @ Nethod         | Route Name               
 * -------------------------------------------------------------------------------------------------------------------------------
 */

$cartSlug = 'gio-hang.html';
$addToCartSlug = 'Them-gio-hang';
$checkoutSlug = 'thanh-toan.html';

Route::get($cartSlug,                                       $c.'viewCart'                )->name($r.'cart');
Route::get($checkoutSlug,                                   $c.'checkout'                )->name($r.'checkout');

Route::post('dat-hang',                                     $c.'placeOrder'              )->name($r.'place-order');
Route::get('xac-thuc-don-hang/{token}',                     $o.'confirmOrder'            )->name($r.'confirm');

Route::get('thanh-toan-chuyen-khoan.html',                  $p.'transfer'                )->name($rp.'transfer');
Route::get('check-order-payment',                           $p.'checkOrderTransfer'      )->name($rp.'check-order');
Route::post('check-order-payment',                          $p.'checkOrderTransfer'      );
Route::post('verify-transfer',                              $p.'save'                    )->name($rp.'verify-transfer');

Route::get('quan-ly-don-hang.html',                         $o.'manager'                 )->name($r.'manager');
Route::get('quan-ly-don-hang/{status_key}.html',            $o.'manager'                 )->name($r.'list');
Route::get('chi-tiet-don-hang/{id}.html',                   $o.'viewDetail'              )->name($r.'detail');

Route::get('dang-nhap-khach-hang.html',                     $customer.'login'            )->name($rc.'login');
Route::post('dang-nhap-khach-hang.html',                    $customer.'createToken'      );
Route::get('xac-minh-khach-hang/{token}',                   $customer.'verify'           )->name($rc.'verify');
Route::get('dang-xuat-khach-hang.html',                     $customer.'logout'           )->name($rc.'logout');



Route::prefix('cart')->group(function () use($c, $r) {
    Route::post('check-price',                              $c.'checkPrice'              )->name($r.'check-price');
    Route::post('add',                                      $c.'addToCart'               )->name($r.'add-to-cart');
    Route::post('add-item',                                 $c.'addItem'                 )->name($r.'add-cart-item');
    Route::post('check-data',                               $c.'checkData'               )->name($r.'check-cart-data');
    Route::post('update-cart-quantity',                     $c.'updateCartQuantity'      )->name($r.'update-cart-quantity');
    Route::post('update-item',                              $c.'updateItem'              )->name($r.'update-cart-item');
    Route::post('update-cart',                              $c.'updateCart'              )->name($r.'update-cart');
    Route::delete('empty',                                  $c.'empty'                   )->name($r.'empty-cart');
    Route::match(['delete','post'],'remove-item/{id?}',     $c.'removeItem'              )->name($r.'remove-cart-item');
        
});




Route::prefix('orders') ->group(function () use($o, $r) {
    Route::post('cancel',                                   $o.'cancel'              )->name($r.'cancel');
});



