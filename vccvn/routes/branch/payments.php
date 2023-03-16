<?php

use Illuminate\Support\Facades\Route;



$controller = 'PaymentController@';
$r = 'payments.';

Route::get('/checkout',                     $controller.'checkout'             )->name($r.'checkout');
Route::get('/transfer',                     $controller.'transfer'             )->name($r.'transfer');
Route::post('/payment',                     $controller.'payment'              )->name($r.'payment');
Route::get('/check-payment',                $controller.'checkPackagePayment'  )->name($r.'check');
Route::post('/check-payment',               $controller.'checkPackagePayment'  );
Route::post('/verify-transfer',             $controller.'save'                 )->name($r.'verify');




$controller = 'PaymentController@';
// $r = 'client.services.';



Route::get('/vnpay-create',                 $controller.'vnPayCreate'          )->name($r.'vnpay-create');
Route::post('/vnpay-create',                $controller.'vnPayCreate'          );



Route::get('/vnpay-status',                 $controller.'vnPayStatus'          )->name($r.'vnpay-status');
Route::post('/vnpay-status',                $controller.'vnPayStatus'          );
Route::get('/vnpay-check',                  $controller.'vnPayCheck'           )->name($r.'vnpay-check');
Route::post('/vnpay-check',                 $controller.'vnPayCheck'           );


