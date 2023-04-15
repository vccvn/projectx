<?php

use Illuminate\Support\Facades\Route;

$controller = 'General\PostCategoryController@';
$route = 'admin.posts.categories';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *  Method | URI                                    | Controller @ Nethod              | Route Name               
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/{dynamic}/categories',                  $controller.'getIndex'            )->name($route);$route.='.';
Route::get('/{dynamic}/categories/list.html',        $controller.'getList'             )->name($route.'list');
Route::get('/{dynamic}/categories/trash.html',       $controller.'getTrash'            )->name($route.'trash');
Route::get('/{dynamic}/categories/ajax-search',      $controller.'ajaxSearch'          )->name($route.'ajax');
Route::get('/{dynamic}/categories/create.html',      $controller.'getCreateForm'       )->name($route.'create');
Route::get('/{dynamic}/categories/update/{id}.html', $controller.'getUpdateForm'       )->name($route.'update');
Route::post('/{dynamic}/categories/save',            $controller.'save'                )->name($route.'save');
Route::post('/{dynamic}/categories/move-to-trash',   $controller.'moveToTrash'         )->name($route.'move-to-trash');
Route::post('/{dynamic}/categories/delete',          $controller.'delete'              )->name($route.'delete');
Route::post('/{dynamic}/categories/restore',         $controller.'restore'             )->name($route.'restore');
Route::get('/{dynamic}/categories/options',          $controller.'getCategoryOptions'  )->name($route.'options');


$controller = 'General\PostController@';
$route = 'admin.posts.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *  Method | URI                                    | Controller @ Nethod              | Route Name               
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::get('/{dynamic}/list.html',                   $controller.'getList'             )->name($route.'list');
Route::get('/{dynamic}/trash.html',                  $controller.'getTrash'            )->name($route.'trash');
Route::get('/{dynamic}/ajax-search',                 $controller.'ajaxSearch'          )->name($route.'ajax');
Route::get('/{dynamic}/create.html',                 $controller.'getCreateForm'       )->name($route.'create');
Route::get('/{dynamic}/update/{id}.html',            $controller.'getUpdateForm'       )->name($route.'update');
Route::get('/{dynamic}/config.html',                 $controller.'getPostConfigForm'   )->name($route.'config');
Route::get('/{dynamic}/form-layout.html',            $controller.'getFormLayoutSetting')->name($route.'form-layout');
Route::post('/{dynamic}/save',                       $controller.'save'                )->name($route.'save');
Route::post('/{dynamic}/move-to-trash',              $controller.'moveToTrash'         )->name($route.'move-to-trash');
Route::post('/{dynamic}/delete',                     $controller.'delete'              )->name($route.'delete');
Route::post('/{dynamic}/restore',                    $controller.'restore'             )->name($route.'restore');
Route::post('/{dynamic}/save-config',                $controller.'saveConfig'          )->name($route.'save-config');
Route::post('/{dynamic}/delete-form-group',          $controller.'deleteFormGroup'     )->name($route.'delete-form-group');
Route::post('/{dynamic}/check-slug',                 $controller.'checkSlug'           )->name($route.'check-slug');
Route::get('/{dynamic}/get-slug',                    $controller.'getSlug'             )->name($route.'get-slug');
Route::get('/{dynamic}.html',                        $controller.'getIndex'            )->name('admin.posts');
