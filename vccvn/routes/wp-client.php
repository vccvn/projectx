<?php

use Illuminate\Support\Facades\Route;

/**
 * --------------------------------------------------------------------------------------------------------------------
 * |                   URI                   |        Controller @ metho d       |             Route Name             |
 * --------------------------------------------------------------------------------------------------------------------
 */
$route = 'client.';
Route::get('/', function () {
    return view('wp.client');
})->name('home');


Route::get('csrf-token', function(){
    if ($token = csrf_token()) {
        $status = true;
        $data = compact('token');
    }
    return [];
})->name('client.token');
Route::get('tim-kiem',function () {
    return view('wp.client');
})->name($route.'search');
Route::any('*', function () {
    return view('wp.client');
});

