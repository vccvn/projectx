<?php

use Illuminate\Support\Facades\Route;

$controller = 'AuthController@';


Route::get('/login',                          $controller.'getLoginForm'          )->name('login');
Route::post('/post-login',                    $controller.'postLogin'             )->name('post-login');
Route::post('/send-email-reset-password',     $controller.'sendEmailResetPassword')->name('post-forgot');
Route::get('/logout',                         $controller.'logout'                )->name('logout');
Route::get('/reset-password/{token?}',        $controller.'getResetPasswordForm'  )->name('password.reset');
Route::post('/save-reset-password',           $controller.'postResetPassword'     )->name('password.reset.save');

Route::get('/errors/{code?}',                 'Admin\General\ErrorController@showError'   )->name('errors');
