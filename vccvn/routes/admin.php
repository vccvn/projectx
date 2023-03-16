<?php

/*
|--------------------------------------------------------------------------
| Web Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * --------------------------------------------------------------------------------------------------------------------
 * |                   URI                   |        Controller @ metho d       |             Route Name             |
 * --------------------------------------------------------------------------------------------------------------------
 */


Route::get('/',                               'DashboardController@getIndex'      )->middleware('auth')->name('dashboard');
Route::get('/dashboard',                      'DashboardController@getIndex'      )->middleware('auth')->name('admin.dashboard');




$routes = [
    // prefix => middleware

    // thêm route ở đây
];
$modules = get_web_module_list(get_web_type());
if(count($modules)){
    foreach ($modules as $module) {
        if($module){
            $routes[] = $module;
        }
    }
}

$routes[] = 'notices';





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
    if($pf && file_exists($path = base_path('routes/admin/'.$pf.'.php'))){
        $router = Route::prefix($pf);
        if($mw){
            $router->middleware($mw);
        }
        $router->group($path);
    }
}


Route::middleware(['dynamic.post'])->group(base_path('routes/admin/posts.php'));
