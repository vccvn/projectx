<?php

// controller
// $c = 'UserController@';

use Illuminate\Support\Facades\Route;
Route::post('auth/login', 'Crazy3D\AuthController@login');
Route::post('api/auth/login', 'Crazy3D\AuthController@login');

$r = 'api.3d.';
/*
|----------------------------------------------------------------------------------------------------------------------------
|                       URL                       |              CONTROLLER               |               NAME
|----------------------------------------------------------------------------------------------------------------------------
*/  
Route::get('/', function(){
})->name($r.'base');
Route::prefix('items')->group(function($router) use($r){
    $c = 'Crazy3D\ModelItemController@';
    Route::get('detail/{id}',                      $c.'detail'                               );
    Route::get('/category',                        $c.'getItemCategories'           )->name($r.'category');
    Route::get('/list',                            $c.'getData'                     )->name($r.'list');
    Route::middleware(['auth.jwt'])->group(function () use($r, $c) {
        Route::put('update/{id}',                  $c.'update3D'                             );
        Route::put('thumbnail/{id}',               $c.'updateThumbnail'                             );

        Route::put('/{id}',                        $c.'update3D'                             );
    });
});
Route::prefix('categories')->group(function($router) use($r){
    $c = 'Crazy3D\ModelItemController@';
    // Route::get('detail/{id}',                      $c.'detail'                               );
    Route::get('/list',                       $c.'getItemCategories'           )->name($r.'category');
    // Route::middleware(['auth.jwt'])->group(function () use($r, $c) {
    //     Route::put('update/{id}',                  $c.'update3D'                             );
    //     Route::put('thumbnail/{id}',               $c.'updateThumbnail'                             );

    //     Route::put('/{id}',                        $c.'update3D'                             );
    // });
});