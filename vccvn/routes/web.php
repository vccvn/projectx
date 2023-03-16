<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

$routes = [
    'home', 'account'
];

$modules = get_web_module_list(get_web_type());
if(count($modules)){
    foreach ($modules as $module) {
        if($module){
            $routes[] = $module;
        }
    }
}


foreach ($routes as $route => $prefix) {
    if(is_numeric($route)){
        if(file_exists($file = base_path('routes/client/'.$prefix. '.php'))){
            Route::namespace('Clients')->group($file);
        }
        
    }else{
        if(file_exists($file = base_path('routes/client/'.$route. '.php'))){
            Route::prefix($prefix)->namespace('Clients')->group($file);
        }
        
    }
    
}

$namespace = 'Clients';

Route::middleware('next')->group(base_path('routes/auth.php'));

Route::namespace($namespace)->group(base_path('routes/client/clients.php'));

Route::namespace($namespace)->group(base_path('routes/client/assets.php'));

Route::namespace($namespace)->group(base_path('routes/client/posts.php'));
