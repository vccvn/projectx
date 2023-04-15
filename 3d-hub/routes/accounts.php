<?php

use Illuminate\Support\Facades\Route;

$controller = 'DashboardController@';
$r = 'accounts';
Route::get('/',                           $controller.'getDashboard'          )->name($r);
$r.='.';


Route::get('/dashboard',                  $controller.'getDashboard'          )->name($r.'dashboard');

$controller = 'SettingController@';
Route::prefix('settings')->group(function() use($controller, $r){
    Route::get('/',                      $controller.'index'                 )->name($r.'settings');
    
    Route::get('tab/{tab}.html',         $controller.'index'                 )->name($r.'settings.tab');
    Route::post('tab/{tab}.html',        $controller.'updateAccount'         );
    Route::post('tab/{tab}',             $controller.'updateAccount'         )->name($r.'settings.save');
});    