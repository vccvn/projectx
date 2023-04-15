<?php

use Illuminate\Support\Facades\Route;

$c = 'AssetController@';
$route = 'client.assets.';

$controller = 'AssetController@';

Route::get(
    '/static/{ref}/{width}x{height}/{filename}',
    $controller.'getImage'
)->name($route . 'image')->where([
    'width' => '[0-9]+',
    'height' => '[0-9]+'
]);
