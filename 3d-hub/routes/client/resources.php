<?php

use Illuminate\Support\Facades\Route;

$c = 'AssetController@';
$route = 'client.assets.';

$controller = 'TagController@';

Route::get('/tags/{tag}.html',                             $controller.'getPosts'       )->name($route . 'tag');

/**
 * -------------------------------------------------------------------------------------------------------------------------------
 *  Method | URI                                           | Controller @ Nethod         | Route Name               
 * -------------------------------------------------------------------------------------------------------------------------------
 */
Route::get('/danh-muc-{dynamic}/{slug}.html',               $c.'viewCategory'            )->name($route.'categories.view-simple');
Route::get('/danh-muc-{dynamic}/{parent}/{child}.html',     $c.'viewCategory'            )->name($route.'categories.view-child');
$prefix = '/{dynamic}/danh-muc/';
Route::get($prefix.'{first}/{second}/{third}.html',         $c.'viewCategory'            )->name($route.'categories.view-3-level');
Route::get($prefix.'{first}/{second}/{third}/{fourth}.html',$c.'viewCategory'            )->name($route.'categories.view-4-level');
Route::get('/danh-muc-{dynamic}/',                          $c.'viewCategory'            )->name($route.'categories.view-by-id');
Route::get('/{dynamic}.html',                               $c.'viewDynamicPage'         )->name('client.posts');
Route::get('/{dynamic}/{post}.html',                        $c.'viewPost'                )->name($route.'view');

Route::get('/{slug}.html',                                  $c.'viewDynamicPage'         )->name('client.pages.view-simple');
Route::get('/{parent}/{child}.html',                        $c.'viewPost'                )->name('client.pages.view-child');
