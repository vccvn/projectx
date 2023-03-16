<?php

use Illuminate\Support\Facades\Route;

$controller = 'FilemanagerController@';
$route = 'filemanager';

$listRoute = ['index'];

add_web_module_routes($controller, $listRoute, $route);

$route.='.';

$ctl = 'FileEditorController@';

/**
 * --------------------------------------------------------------------------------------------------------------------
 * |                    URI                    |       Controller @ method       |             Route Name             |
 * --------------------------------------------------------------------------------------------------------------------
 */

Route::get('create-file',                  $ctl.'createFile'                      )->name($route.'create-file');

Route::post('create-folder',               $controller.'createFolder'             )->name($route.'folders.make');

Route::get('get-folder-size',              $controller.'getFolderSize'            )->name($route.'folders.size');

Route::get('upload',                       $controller.'showUploadForm'           )->name($route.'upload.form');
Route::post('do-upload',                   $controller.'doUpload'                 )->name($route.'upload.save');
Route::get('download',                     $controller.'download'                 )->name($route.'download');
Route::post('unzip',                       $controller.'unzip'                    )->name($route.'items.unzip');

Route::post('create',                      $controller.'createFile'               )->name($route.'items.create');
Route::post('rename',                      $controller.'rename'                   )->name($route.'items.rename');
Route::post('move-items',                  $controller.'moveItems'                )->name($route.'items.move');
Route::post('delete-items',                $controller.'deleteItems'              )->name($route.'items.delete');

Route::get('editor',                       $controller.'editor'                   )->name($route.'editor');

Route::post('save-file-content',           $controller.'saveFileContent'          )->name($route.'files.save');
Route::post('install-package',             $controller.'installPackage'           )->name($route.'packages.install');
Route::post('command',                     $controller.'command'                  )->name($route.'command');
