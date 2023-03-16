<?php

use Illuminate\Support\Facades\Route;

$c = 'PostController@';
$route = 'client.posts.';

$controller = 'TagController@';

Route::get('/tags/{tag}.html',                             $controller.'getPosts'       )->name($route . 'tag');

$controller = 'SitemapController@';

Route::get('/sitemap.xml',                                 $controller.'sitemap'       )->name('client.sitemap');


/**
 * -------------------------------------------------------------------------------------------------------------------------------
 *  Method | URI                                           | Controller @ Nethod         | Route Name               
 * -------------------------------------------------------------------------------------------------------------------------------
 */
Route::get('/danh-muc-{dynamic}/',                          $c.'viewCategory'            )->name($route.'categories.view-by-id');
Route::get('/{dynamic}.html',                               $c.'viewDynamicPage'         )->name('client.posts');
Route::get('/{dynamic}/{post}.html',                        $c.'viewPost'                )->name($route.'view');

Route::get('/{slug}.html',                                  $c.'viewDynamicPage'         )->name('client.pages.view-simple');
Route::get('/{parent}/{child}.html',                        $c.'viewPost'                )->name('client.pages.view-child');


$prefix = '/{dynamic}';
Route::get($prefix.'/{slug}/',                              $c.'viewCategory'            )->name($route.'categories.view-simple');
Route::get($prefix.'/{parent}/{child}/',                    $c.'viewCategory'            )->name($route.'categories.view-child');
Route::get($prefix.'/{first}/{second}/{third}/',            $c.'viewCategory'            )->name($route.'categories.view-3-level');
Route::get($prefix.'/{first}/{second}/{third}/{fourth}/',   $c.'viewCategory'            )->name($route.'categories.view-4-level');

