<?php

namespace App\Repositories\Permissions;


use App\Repositories\Base\BaseRepository;


use Crazy\Laravel\Router;

class RouteRepository extends BaseRepository
{

    protected static $routes = [
        'list' => [],
        'name' => [],
        'prefix' => [],
    ];
    protected static $prefixList = [];

    /**
     * get model
     * @return string
     */
    public function getModel()
    {
        return \App\Models\PermissionModule::class;
    }

    public function init()
    {
        $this->checkRoute();
    }


    /**
     * kiểm tra và set route từ laravel
     * 
     * @return void
     */
    public function checkRoute()
    {
        if(!count(self::$routes['list'])){
            $routes = Router::all();
            if(count($routes)){
                foreach ($routes as $uri => $route) {
                    if(!preg_match('/^oauth\//i', $uri)){
                        if(!isset(self::$routes['list'][$uri])){
                            self::$routes['list'][$uri] = $route;
                        }
                        if($route['name'] && !isset(self::$routes['name'][$route['name']])){
                            self::$routes['name'][$route['name']] = $route;
                        }
                        if($route['prefix'] && !in_array($route['prefix'], self::$routes['prefix'])){
                            self::$routes['prefix'][] = $route['prefix'];
                            self::$prefixList[] = $route;
                        }
                    }
                }
            }
        }
    }

    /**
     * lay ds route
     */
    public function getRouteList()
    {
        return self::$routes['list'];
    }

    public function getRouteUri($uri = null)
    {
        if(!$uri) return self::$routes['list'];
        return isset(self::$routes['list'][$uri]) ? (self::$routes['list'][$uri]) : null;
    }

    public function getRouteName($name = null)
    {
        if(!$name) return self::$routes['name'];
        return isset(self::$routes['name'][$name]) ? (self::$routes['name'][$name]) : null;
    }

    public function getRoutePrefix($prefix = null)
    {
        if(!$prefix) return self::$prefixList;
        $data = [];
        if(in_array($prefix, self::$routes['prefix'])){
            foreach(self::$routes['list'] as $key => $route){
                if($route['prefix'] && $prefix == $route['prefix']){
                    $data[] = $route;
                }
            }
        }
        return $data;
    }

    public function getRoute($type = 'uri', $param = null)
    {
        $t = strtolower($type);
        if($t=='uri') return $this->getRouteUri($param);
        elseif($t=='name') return $this->getRouteName($param);
        elseif($t=='prefix') return $this->getRoutePrefix($param);
        return null;
    }


    public function getRouteOptions($type = 'uri')
    {
        $data = ["" => "Chọn một"];
        if($routes = $this->getRoute($type)){
            if($type=='name'){
                foreach ($routes as $route) {
                    $data[$route[$type]] = $route[$type] . ' => '. $route['uri'];
                }
            }else{
                foreach ($routes as $route) {
                    if(isset($route[$type]) && $route[$type]){
                        $data[$route[$type]] = $route[$type];
                    }
                    
                }
            }
        }
        return $data;
    }

    public static function getOptions($type = null)
    {
        if(in_array($t = strtolower($type), ['uri', 'name', 'prefix']) && $routes = (new static())->getRouteOptions($t)){
            return $routes;
        }
        return [];
    }
}