<?php
use Illuminate\Support\Facades\Route;

$controller = 'General\DynamicController@';
$route = 'dynamics';
admin_routes($controller, $route, true);
$route = 'admin.'.$route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/select-options',                $controller.'getSelectOptions'         )->name($route.'select-option');
Route::post('/check-slug',                   $controller.'checkSlug'                )->name($route.'check-slug');
Route::get('/get-slug',                      $controller.'getSlug'                  )->name($route.'get-slug');


Route::get('posts-categories-options',       $controller.'getCategoryOptions'       )->name('admin.posts.category-options');