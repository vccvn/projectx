<?php


Route::get('/', 'HomeController@index')->name('home');
Route::get('/index.html', 'HomeController@index') ->name('client.home');
Route::get('/home', 'HomeController@index');


Route::get('profile', 'HomeController@home')->name('profile');

Route::get('/thong-bao.html', 'AlertController@message') ->name('client.alert');

Route::get('csrf-token', 'HomeController@getCSRFToken')->name('client.token');