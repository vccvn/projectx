<?php
$controller = "TestController@";

Route::any('test', $controller.'test');

Route::post('save-data', 'CrawlerController@test');