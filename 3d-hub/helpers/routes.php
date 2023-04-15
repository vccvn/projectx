<?php

use Crazy\Laravel\Router;
use Illuminate\Support\Facades\Route;

if(!function_exists('get_route_options')){
    /**
     * lấy thông tin route trả về dạng option key => value
     *
     * @param string $prefix
     * @return array
     */
    function get_route_options($prefix = null)
    {
        $data = [];
        $routes = Router::getSelectNameAndUri();
        if($prefix){
            if($prefix == 'client'){
                foreach ($routes as $name => $uri) {
                    if(preg_match('/^'.$prefix.'\./i', $name) || $uri == '/'){
                        $data[$name] = $uri;
                    }
                }
            }else{
                foreach ($routes as $name => $uri) {
                    if(preg_match('/^'.$prefix.'\./i', $name)){
                        $data[$name] = $uri;
                    }
                }
            }
        }else{
            $data = $routes;
        }
        return $data;
    }
}

if(!function_exists('add_web_module_routes')){
    /**
     * dinh nghia cac route cho một module
     * @param string $controller class
     * @param boolean $require_index_route 
     * @param string $route      prefix of route
     * 
     * @return void
     */
    function add_web_module_routes($controller, $list = [], $route = null, $scope = ''){
        $routeData = [
            'index'            => ['get', '/', 'getIndex', ''],
            'list'             => ['get', 'list.html', 'getList', 'list'],
            'trash'            => ['get', 'trash.html', 'getTrash', 'trash'],
            'detail'           => ['get', 'detail/{id}.html', 'getDetail', 'detail'],
            'ajax'             => ['get', 'ajax-search', 'ajaxSearch', 'ajax'],
            'create'           => ['get', 'create.html', 'getCreateForm', 'create'],
            'update'           => ['get', 'update/{id}.html', 'getUpdateForm', 'update'],
            'save'             => ['post', 'save', 'save' , 'save'],
            'move-to-trash'    => ['post', 'move-to-trash', 'moveToTrash' , 'move-to-trash'],
            'delete'           => ['post', 'delete', 'delete' , 'delete'],
            'restore'          => ['post', 'restore', 'restore' , 'restore'],
            'form-config'      => ['get', 'form/config/{action?}', 'getConfigForm', 'form.config.edit'],
            'form.config-save' => ['post', 'form/config/save', 'saveConfigForm', 'form.config.save']
        ];

        if(!is_array($list)){
            if(in_array($list, ['all', '*']) || !$list){
                $list = array_keys($routeData);
            }elseif (array_key_exists($list, $routeData)) {
                $list = [$list];
            }else{
                return false;
            }
        }elseif(!count($list)){
            $list = array_keys($routeData);
        }

        if($route){
            if($scope) $route = $scope . '.' .$route;
        }
        foreach ($list as $key) {
            if(array_key_exists($key, $routeData)){
                $detail = $routeData[$key];
                $router = call_user_func_array(['Route', $detail[0]], [$detail[1], $controller.$detail[2]]);
                if($route){
                    if($detail[3]){
                        $router->name($route. '.' . $detail[3]);
                    }else{
                        $router->name($route);
                    }
                }

            }
        }
    
    }
}


if(!function_exists('api_routes')){
    /**
     * dinh nghia cac route cho một module nào đó phần manager
     * @param string $controller class
     * @param string $route      prefix of route
     * @param boolean $require_index_route 
     * 
     * @return void
     */
    function api_routes($controller, $route = null, $require_index_route = false){
        /**
         * --------------------------------------------------------------------------------------------------------------------
         *    Method | URI                                | Controller @ Nethod              | Route Name                     |
         * --------------------------------------------------------------------------------------------------------------------
         */
        
        if($route){
            if($require_index_route) {Route::get('/',       $controller.'index'               )->name($route);}$route.='.';
            Route::get('/list',                             $controller.'index'               )->name($route.'list');
            Route::get('/trash',                            $controller.'trash'               )->name($route.'trash');
            Route::get('/detail/{id}',                      $controller.'detail'              )->name($route.'detail');
            Route::post('/create',                          $controller.'create'              )->name($route.'create');
            Route::post('/store',                           $controller.'store'               )->name($route.'store');
            Route::put('/update/{id}',                      $controller.'update'              )->name($route.'update');
            Route::post('/save',                            $controller.'save'                )->name($route.'save');
            Route::delete('/move-to-trash',                 $controller.'moveToTrash'         )->name($route.'move-to-trash');
            Route::delete('/delete',                        $controller.'delete'              )->name($route.'delete');
            Route::put('/restore',                          $controller.'restore'             )->name($route.'restore');
            
        }else{
            if($require_index_route)  Route::get('/',       $controller.'index');
            Route::get('/list',                             $controller.'index');
            Route::get('/trash',                            $controller.'trash');
            Route::get('/detail/{id}',                      $controller.'detail');
            Route::post('/create',                          $controller.'create');
            Route::post('/store',                           $controller.'store');
            Route::put('/update/{id}',                      $controller.'update');
            Route::post('/save',                            $controller.'save');
            Route::delete('/move-to-trash',                 $controller.'moveToTrash');
            Route::delete('/delete',                        $controller.'delete');
            Route::put('/restore',                          $controller.'restore');
        }
    }
}




if(!function_exists('admin_routes')){
    /**
     * dinh nghia cac route cho một module nào đó phần manager
     * @param string $controller class
     * @param string $route      prefix of route
     * @param boolean $require_index_route 
     * 
     * @return void
     */
    function admin_routes($controller, $route = null, $require_index_route = false){
        $routeData = [
            'index', 'list', 'trash', 'detail', 'ajax',  'create', 'update',
            'save', 'move-to-trash', 'delete', 'restore', 'form-config', 'form.config-save'
        ];
        
        if(!$require_index_route) array_shift($routeData);

        return add_web_module_routes($controller, $routeData, $route, 'admin');
    }
        
}


if(!function_exists('manager_routes')){
    /**
     * dinh nghia cac route cho một module nào đó phần manager
     * @param string $controller class
     * @param string $route      prefix of route
     * @param boolean $require_index_route 
     * 
     * @return void
     */
    function manager_routes($controller, $route = null, $require_index_route = false){
        $routeData = [
            'index', 'list', 'trash', 'detail', 'ajax',  'create', 'update',
            'save', 'move-to-trash', 'delete', 'restore', 'form-config', 'form.config-save'
        ];
        
        if(!$require_index_route) array_shift($routeData);

        return add_web_module_routes($controller, $routeData, $route);
    }
}





