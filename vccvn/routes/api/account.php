<?php

use Illuminate\Support\Facades\Route;

$controller = "testController@";

Route::any('test', $controller.'test');
?>