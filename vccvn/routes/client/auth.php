<?php


$controller = 'AuthController@';
$r = 'client.auth.';

/**
 * -------------------------------------------------------------------------------------------------------------------------------
 *  Method | URI                             | Controller @ Nethod               | Route Name               
 * -------------------------------------------------------------------------------------------------------------------------------
 */

Route::get('dang-nhap.html',                  $controller.'getLoginForm'          )->name($r.'login');
Route::post('dang-nhap.html',                 $controller.'postLogin'             );
Route::post('dang-nhap',                      $controller.'postLogin'             )->name($r.'post-login');
Route::get('quen-mat-khau.html',              $controller.'getForgotForm'         )->name($r.'forgot');
Route::post('quen-mat-khau.html',             $controller.'sendEmailResetPassword');
Route::post('quen-mat-khau',                  $controller.'sendEmailResetPassword')->name($r.'post-forgot');

Route::get('cfp-token/{token?}',              $controller.'confirmPasswordToken'  )->name($r.'password.confirm-token');
Route::get('dat-lai-mat-khau.html',           $controller.'getResetPasswordForm'  )->name($r.'password.reset');
Route::post('dat-lai-mat-khau.html',          $controller.'postResetPassword'     );

Route::get('dang-ky.html',                    $controller.'getRegisterForm'       )->name($r.'register');
Route::post('dang-ky.html',                   $controller.'postRegister'          );
Route::post('dang-ky',                        $controller.'postRegister'          )->name($r.'post-register');

Route::get('xac-minh-tai-khoan.html',         $controller.'getVerifiForm'         )->name($r.'verify.form');
Route::post('xac-minh-tai-khoan.html',        $controller.'SendVerifyEmail'       );
Route::post('gui-email-xac-minh',             $controller.'SendVerifyEmail'       )->name($r.'verify.send-email');
Route::get('verify-email/{token?}',           $controller.'verifyEmail'           )->name($r.'verify-email');
Route::any('dang-xuat',                       $controller.'logout'                )->name($r.'logout');

Route::post('check-auth',                     'CheckAuthController@check'         )->name($r.'check');
