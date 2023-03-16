<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function(Request $request){
    return response(['text' => 'hello world']);
});

$aa = 'auth:api';
$auth = [$aa];

$routes = [
    // prefix => middleware
    'admin',
    'users',// => $auth,
    'test',
    'tasks',
    'auth',
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
        $router->group(base_path('routes/api/'.$pf.'.php'));
    }
}