<?php

use Illuminate\Support\Facades\Route;



$controller = 'PaymentController@';
$r = 'payments.';







$controller = 'VNPayController@';
// $r = 'client.services.';

$r = 'payments.vnpay.';


Route::get('/vnpay-create',                 $controller.'vnPayCreate'          )->name($r.'create');
Route::post('/vnpay-create',                $controller.'vnPayCreate'          );



Route::get('/vnpay-status',                 $controller.'vnPayStatus'          )->name($r.'status');
Route::post('/vnpay-status',                $controller.'vnPayStatus'          );
Route::get('/vnpay-check',                  $controller.'vnPayCheck'           )->name($r.'check');
Route::post('/vnpay-check',                 $controller.'vnPayCheck'           );


