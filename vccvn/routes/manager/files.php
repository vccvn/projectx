<?php
use Illuminate\Support\Facades\Route;

$controller = 'FileController@';
$route = 'files';
manager_routes($controller, 'files', true);
$route = $route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::post('/dz-upload-image',               $controller.'dzUpload'                 )->name($route.'images.dz-upload');

Route::get('/get-images',                     $controller.'getImageData'             )->name($route.'images.get-data');

Route::post('/dz-upload-media',               $controller.'dzUploadMedia'            )->name($route.'media.dz-upload');

Route::get('/get-media',                      $controller.'getMediaData'             )->name($route.'media.get-data');

