<?php
use Illuminate\Support\Facades\Route;



$rp = 'client.payments.';
$p = 'PaymentController@';


/**
 * -------------------------------------------------------------------------------------------------------------------------------
 *  Method | URI                                           | Controller @ Nethod         | Route Name
 * -------------------------------------------------------------------------------------------------------------------------------
 */

Route::get('thanh-toan-chuyen-khoan.html',                  $p . 'transfer'              )->name($rp . 'transfer');
Route::get('check-order-payment',                           $p . 'checkOrderPayment'     )->name($rp . 'check-order');
Route::post('check-order-payment',                          $p . 'checkOrderPayment'     );
Route::post('verify-transfer',                              $p . 'verifyTransfer'        )->name($rp . 'verify-transfer');



Route::get('/vnpay',                                        $p . 'vnPay'                 )->name($rp . 'vnpay');
Route::get('/vnpay/form',                                   $p . 'vnPay'                 )->name($rp . 'vnpay.form');
Route::get('/vnpay/create',                                 $p . 'vnPayCreate'           )->name($rp . 'vnpay.submit');
Route::post('/vnpay/create',                                $p . 'vnPayCreate'           );

Route::get('/vnpay/check',                                  $p . 'vnPayCheck'            )->name($rp . 'vnpay.check');
Route::post('/vnpay-check',                                 $p . 'vnPayCheck'            );

Route::get('/vnpay/status',                                 $p . 'vnPayStatus'           )->name($rp . 'vnpay.status');
Route::post('/vnpay/status',                                $p . 'vnPayStatus'           );
