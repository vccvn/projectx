<?php

namespace App\Http\Controllers\Clients;

use App\Engines\Breadcrumb;
use App\Engines\CacheEngine;
use App\Engines\ViewManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Htmlable;
use Mobile_Detect;

class ClientController extends Controller
{

    public static $isShare = false;
    /**
     * @var string $routeNamePrefix
     */
    protected $routeNamePrefix = 'clients.';

    /**
     * @var string $viewFolder thu muc chua view
     * khong nen thay doi lam gi
     */
    protected $viewFolder = 'clients';
    /**
     * @var string dường dãn thư mục chứa form
     */
    protected $formDir = 'clients/forms';

    /**
     * @var string $menuName
     */
    protected $menuName = 'client_menu';
    
    protected $scope = 'clients';

    /**
     * thời gian lưu chữ cache của view
     *
     * @var integer
     */
    public $cacheViewTime = 0;

    /**
     * thời gian lưu cach3 của data lấy từ db
     *
     * @var integer
     */
    public $cacheDataTime = 0;



    /**
     * path khi su dung view cache
     *
     * @var string
     */
    public $cacheViewPrefixPath = 'modules.';

    /**
     * Breakcrump
     * @var \App\Engines\Breadcrumb $breadcrumb
     */
    protected $breadcrumb  = null;


    /**
     * chế độ view
     *
     * @var string $viewMode 
     */
    public $viewMode = 'module';

    /**
     * device
     *
     * @var \Mobile_Detect
     */
    public $device = null;

    protected function shareDefaultData($name = null, $value = null)
    {
        if(self::$isShare) return true;
        ViewManager::share($name, $value);
        self::$isShare = true;
    }

    public function init()
    {
        
        $this->cacheViewTime = system_setting('cache_view_time', 0);
        $this->cachDatawTime = system_setting('cache_data_time', 0);
        $this->viewFolder = 'clients.'.theme_path();
        $this->breadcrumb = app(Breadcrumb::class);
        $this->device = app(Mobile_Detect::class);
        set_web_data('mobile_detect', $this->device);
        $this->shareDefaultData([
            'breadcrumb' => $this->breadcrumb ,
            '_device' => $this->device, 
        ]);
        
        parent::init();
    }

    
    /**
     * view
     * @param string $bladePath
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function view(string $bladePath, array $data = [])
    {
        $bp = ($this->viewMode == 'module'?'modules.':'') . $bladePath;
        $viewdata = array_merge($data, [
            'module_slug' => $this->module,
            'module_name' => $this->moduleName,
            'route_name_prefix' => $this->routeNamePrefix
        ]);
        return ViewManager::theme($bp, $viewdata);
    }

    /**
     * giống view nhung trỏ sẵn vào module
     * @param string $bladeName
     * @param array $data dữ liệu truyền vào
     */
    public function viewModule($subModule, array $data = [])
    {
        return $this->view(($this->viewMode != 'module'?'modules.':'').$this->moduleBlade . ($subModule? '.' . $subModule:''), $data);
    }

    /**
     * check view
     * @param string $bladePath
     * @return boolean
     */
    public function checkViewExists(string $bladePath)
    {
        $bp = ($this->viewMode == 'module'?'modules.':'') . $bladePath;
        return ViewManager::checkThemeView($bp);
    }

    /**
     * kiểm tra module có tồn tại hay không
     * @param string $bladeName
     * @return boolean
     */
    public function checkModuleExists($subModule)
    {
        return $this->checkViewExists(($this->viewMode != 'module'?'modules.':'').$this->moduleBlade . ($subModule? '.' . $subModule:''));
    }


    /**
     * lấy thông tin cche của view
     *
     * @param Request $request
     * @param string $bladeName
     * @param mixed $data
     * @param string $key
     * @param string $use_param
     * @return mixed
     */
    public function cacheView(Request $request, $bladeName=null, $data = null, $key = null, $use_param = false)
    {
        // trường hợp không cache 
        $id = ($user = $request->user()) ? $user->id : null;
        if($id || $this->cacheViewTime <= 0) {
            if(is_array($data)) $viewData = $data;
            elseif (is_callable($data) && is_array($calledData = $data($request))) $viewData = $calledData;
            else $viewData = [];
            $html = $this->view($bladeName, $viewData);
            return $html;
        }
        
        if(!$key) $key = $bladeName;
        $key = 'view-'.$key;
        if($use_param){
            $params = $request->all();
            ksort($params);
        }else{
            $params = [];
        }
        
        
        if(!($html = CacheEngine::get($key, $params)) ){
            $viewData = [];
            if(is_array($data)) $viewData = $data;
            elseif (is_callable($data) && is_array($calledData = $data($request))) {
                $viewData = $calledData;
            }
            $html = $this->view($bladeName, $viewData);
            if(!$id && $this->cacheViewTime > 0){
                $html = $html->render();
                CacheEngine::set($key, $html, $this->cacheViewTime, $params);
            }
        }
        return $html;
    }

    /**
     * lấy cache module hoặc tạo mới
     *
     * @param Request $request
     * @param string $subModule
     * @param array|callable $data
     * @param string $key
     * @param bool $use_param
     * @return View
     */
    public function cacheViewModule(Request $request, $subModule, $data = null, $key = null, $use_param = false)
    {
        if(!$key) $key = $subModule;
        $key = 'module-'.$key;
        return $this->cacheView($request,  $this->moduleBlade . '.' . $subModule, $data, $key,$use_param);
    }



    /**
     * thao tác với data trong csdl thông qua hàm callback
     *
     * @param string $key
     * @param callable $callback
     * @return mixed
     */
    public function cacheData($key, $callback)
    {
        $k = (static::class) . '-data-' .$key;

        if($this->cacheDataTime <= 0 || !($data = CacheEngine::get($k)) ){
            $d = null;
            if (is_callable($callback) && $calledData = $callback()) {
                $d = $calledData;
            }
            if ($d instanceof Htmlable) {
                $data = $d->toHtml();
            }elseif (is_a($d, \Illuminate\View\View::class)) {
                $data = $d->render();
            }
            elseif (is_object($d) && method_exists($d, 'render')) {
                $data = $d->render();
            }
            else{
                $data = $d;
            }
            
            if($this->cacheDataTime > 0){
                CacheEngine::set($k, $data, $this->cacheDataTime);
            }
        }
        return $data;
    }

    /**
     * cache theo url
     *
     * @param Request $request
     * @param bool $withQueryString
     * @param \Closure $callback
     * @return mixed
     */
    protected function cacheUrl(Request $request, $withQueryString = false, $callback = null)
    {
        $id = ($user = $request->user()) ? $user->id : null;
        if($id || $this->cacheViewTime <= 0) {
            if (is_callable($callback)) {
                return $callback($request);
            }
            return $callback;
        }
        $uri = $withQueryString ? $request->getRequestUri() : $request->getPathInfo();
        $isMobileKey = $this->device->isMobile() ? 'mobile-': 'desktop-';
        $urlKey = $isMobileKey.'cache-url-'.$uri;
        if(!($data = CacheEngine::get($urlKey)) ){
            $d = null;
            if (is_callable($callback) && $calledData = $callback($request)) {
                $d = $calledData;
            }
            if ($d instanceof Htmlable) {
                $data = $d->toHtml();
            }elseif (is_a($d, \Illuminate\View\View::class)) {
                $data = $d->render();
            }
            elseif (is_object($d) && method_exists($d, 'toArray')) {
                $data = $d->toArray();
            }
            elseif (is_object($d) && method_exists($d, 'render')) {
                $data = $d->render();
            }
            else{
                $data = $d;
            }
            
            if(!$id && $this->cacheViewTime > 0){
                CacheEngine::set($urlKey, $data, $this->cacheViewTime);
            }
        }
        return $data;
    }


    /**
     * lấy thông tin cache của view
     *
     * @param Request $request
     * @param string $key
     * @param \Closure $callback
     * @return mixed
     */
    public function cache(Request $request, $key, $callback = null)
    {
        $id = ($user = $request->user()) ? $user->id : null;
        if($id || $this->cacheViewTime <= 0) {
            if (is_callable($callback)) {
                return $callback($request);
            }
            return $callback;
        }
        $urlKey = 'cache-controller-'.$key.'-'.str_slug($request->getRequestUri());
        
        if(!($data = CacheEngine::get($urlKey))){
            $d = null;
            if (is_callable($callback) && $calledData = $callback($request)) {
                $d = $calledData;
            }
  
            if ($d instanceof Htmlable) {
                $data = $d->toHtml();
            }elseif (is_a($d, \Illuminate\View\View::class)) {
                $data = $d->render();
            }
            elseif (is_object($d) && method_exists($d, 'toArray')) {
                $data = $d->toArray();
            }
            elseif (is_object($d) && method_exists($d, 'render')) {
                $data = $d->render();
            }
            else{
                $data = $d;
            }
            if(!$id && $this->cacheViewTime > 0){
                CacheEngine::set($urlKey, $data, $this->cacheViewTime);
            }
        }
        return $data;
    }






    
    /**
     * lấy cache task của repository
     *
     * @param Request $request
     * @param string $key
     * @param \App\Repositories\Base\BaseRepository $repository
     * @return \App\Repositories\Base\BaseRepository|\App\Repositories\Base\CacheTask
     */
    public function cacheTask(Request $request, $key, $repository = null)
    {
        if(!$repository) $repository = $this->repository;
        return $repository->cache($key, $this->cacheDataTime, $request->all());
    }


}
