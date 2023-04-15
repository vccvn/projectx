<?php

use Illuminate\Support\Facades\Route;


Route::prefix('services')->group(function(){
    Route::middleware('client.auth')->group(function(){
        $controller = 'ServiceController@';
        $r = 'client.services.';

        Route::get('/',                             $controller.'getServices'          )->name($r.'list');
        Route::get('/list',                         $controller.'getServices'          )->name($r.'list');
        // Route::get('/list2',                         $controller.'getServices2'          )->name($r.'list2');
        Route::get('/my-services',                  $controller.'getServices'          )->name($r.'my-service');

        Route::get('/add',                          $controller.'getServiceForm'       )->name($r.'add');
        Route::post('/add',                         $controller.'addService'           );



        $controller = 'ServicePaymentController@';

        Route::get('/checkout',                     $controller.'checkout'             )->name($r.'checkout');
        Route::get('/transfer',                     $controller.'transfer'             )->name($r.'transfer');
        Route::get('/payment',                      $controller.'transfer'             );
        Route::post('/payment',                     $controller.'payment'              )->name($r.'payment');
        Route::get('/check-payment',                $controller.'checkServicePayment'  )->name($r.'check-payment');
        Route::post('/check-payment',               $controller.'checkServicePayment'  );
        Route::post('/verify-transfer',             $controller.'save'                 )->name($r.'verify-transfer');

        Route::get('/vnpay-create',                 $controller.'vnPayCreate'          )->name($r.'vnpay-create');
        Route::post('/vnpay-create',                $controller.'vnPayCreate'          );

    });
    $controller = 'ServicePaymentController@';
    $r = 'client.services.';

    Route::get('/vnpay-status',                 $controller.'vnPayStatus'          )->name($r.'vnpay-status');
    Route::post('/vnpay-status',                $controller.'vnPayStatus'          );
    Route::get('/vnpay-check',                  $controller.'vnPayCheck'           )->name($r.'vnpay-check');
    Route::post('/vnpay-check',                 $controller.'vnPayCheck'           );


    Route::get('/nganluong-status',                 $controller.'vnPayStatus'          )->name($r.'nganluong-status');
    Route::post('/nganluong-status',                $controller.'vnPayStatus'          );
    Route::get('/nganluong-check',                  $controller.'vnPayCheck'           )->name($r.'nganluong-check');
    Route::post('/nganluong-check',                 $controller.'vnPayCheck'           );


});
