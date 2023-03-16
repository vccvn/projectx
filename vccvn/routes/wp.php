<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Manager Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Manager routes for your application.
|
*/



/**
 * --------------------------------------------------------------------------------------------------------------------
 * |                   URI                   |        Controller @ metho d       |             Route Name             |
 * --------------------------------------------------------------------------------------------------------------------
 */



$controller = 'AuthController@';
$route = 'auth.';


Route::get('/login',                          $controller.'getLoginForm'          )->name('login');
Route::post('/post-login',                    $controller.'postLogin'             )->name('post-login');
Route::post('/send-email-reset-password',     $controller.'sendEmailResetPassword')->name('post-forgot');
Route::get('/logout',                         $controller.'logout'                )->name('logout');
Route::get('/reset-password/{token?}',        $controller.'getResetPasswordForm'  )->name('password.reset');
Route::post('/save-reset-password',           $controller.'postResetPassword'     )->name('password.reset.save');

Route::get('/errors/{code?}',                 'ErrorController@showError'         )->name('errors');



Route::middleware(['auth', 'wp.manager'/*, '2fa'*/])->group(function () {
    Route::get('/',                               'DashboardController@getIndex'      )->name('home');
    Route::get('/home',                           'DashboardController@getIndex'      );
    Route::get('/dashboard',                      'DashboardController@getIndex'      )->name('dashboard');
    Route::get('/update-features',                'UpdateFeatureController@updateFeatures')->name('features.update');

    $routes = [
        // prefix => middleware
        'account',
        'notices',
        'filemanager',
        'database',
        'config',
        'domain'


        // thêm route ở đây
    ];
    foreach ($routes as $prefix => $middleware) {
        $mw = null; // middleware
        $pf = null; // prefix
        if(!is_numeric($prefix)){
            $pf = $prefix;
            if($middleware){
                $mw = $middleware;
            }
        }else{
            $pf = $middleware;
        }
        if($pf){
            $router = Route::prefix($pf);
            if($mw){
                $router->middleware($mw);
            }
            $router->group(base_path('routes/wp/'.$pf.'.php'));
        }
    }

});

Route::post('/2fa', 'Google2FAController@check2fa')->name('2fa')->middleware('2fa');

Route::get('/setup-2fa', 'Google2FAController@showQr')->middleware('auth')->name('setup-2fa');
