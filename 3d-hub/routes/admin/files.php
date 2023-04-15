<?php

$controller = 'General\FileController@';
$route = 'files';
admin_routes($controller, $route, true);
$route = 'admin.'.$route.'.';
/**
 * --------------------------------------------------------------------------------------------------------------------
 *    Method | URI                           | Controller @ Nethod                   | Route Name                     |
 * --------------------------------------------------------------------------------------------------------------------
 */
Route::post('/dz-upload-image',               $controller.'dzUpload'                 )->name($route.'images.dz-upload');

Route::get('/get-images',                     $controller.'getImageData'             )->name($route.'images.get-data');

