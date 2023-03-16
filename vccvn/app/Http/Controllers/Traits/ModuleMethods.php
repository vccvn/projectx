<?php

namespace App\Http\Controllers\Traits;

use Crazy\Helpers\Arr;
use Illuminate\Http\Request;

use Crazy\Html\Menu;

use Crazy\Laravel\Router;

/**
 * các thuộc tính và phương thức của form sẽ được triển trong ManagerController
 */
trait ModuleMethods
{
    /**
     * @var \App\Repositories\Base\BaseRepository
     */
    public $repository;

    /**
     * @var string $module day là tên module cung la ten thu muc view va ten so it cua bang, thu muc trong asset
     * override del chinh sua
     */
    protected $module = 'test';

    /**
     * @var string $module day là duong dan blade den thu muc cua module bo qua nếu nó cùng tên với module
     * override del chinh sua
     */
    protected $moduleBlade = null;

    /**
     * @var string $moduleName tên của module và cũng là tiêu đề trong form
     */
    protected $moduleName = '';

    /**
     * @var string $routeNamePrefix
     */
    protected $routeNamePrefix = '';

    /**
     * @var string $menuName
     */
    protected $menuName = 'menu';

    /**
     * @var bool $flashMode cho biết có chia chức năng này thành module rieng ko hay sử dụng trung
     * Chuẩn hóa module thoe mguyen6 mẫu Crazy CMS 
     */
    protected $flashMode = false;
    
    /**
     * @var string $modulePath
     */
    protected $modulePath = '';

    protected $scope = '';

    /**
     * lấy dữ liệu damg5 danh sách
     * @param Request $request
     * @param array $args
     *
     * @return collection
     */
    public function getResults(Request $request, array $args = [])
    {
        return $this->repository->getResults($request, $args);
    }

    /**
     * thiết lập module
     */
    public function moduleInit()
    {
        if(!$this->moduleBlade) $this->moduleBlade = $this->module;
        
        $this->repository->notTrashed();

        $this->modulePath = $this->scope.'/modules/'.str_replace('.', '/', $this->module);

    }

    /**
     * actice module menu
     */
    public function activeMenu($activeKey = null)
    {
        Menu::addActiveKey($this->menuName, $activeKey?$activeKey:$this->module);
    }

    /**
     * get route url
     * @param string $routeName
     * @param array $params
     * 
     * @return string
     */
    public function getRouteUrl($routeName = null, array $params = [])
    {
        if(!is_string($routeName) || !strlen($routeName)) return null;
        if (Router::getByName($this->routeNamePrefix.$routeName)) {
            return route($this->routeNamePrefix.$routeName, $params);
        }
        return null;
    }

    /**
     * get route url
     * @param string $routeName
     * @param array $params
     * 
     * @return Route
     */
    public function getModuleRoute($routeName = null, array $params = [])
    {
        return $this->getRouteUrl($this->module.'.'.$routeName, $params);
    }

    /**
     * thêm nút thêm mới
     * 
     */
    public function addHeaderButtons(...$buttons)
    {
        $btns = [
            'create' => [
                'url' => $this->getModuleRoute('create'),
                'text' => 'Thêm mới',
                'icon' => 'plus'
            ]
        ];
        $data = [];
        if($buttons){
            foreach($buttons as $i => $button){
                if(isset($btns[$button])){
                    $data[] = $btns[$button];
                }
            }
            admin_breadcrumbs($data);
        }
    }


    
    /**
     * lấy dữ liệu list
     * @param Arr $config
     * 
     */
    public function getListConfigData()
    {
        $data = [];
        // nếu sử dụng flash mode
        if($this->flashMode){
            $file = $this->modulePath.'/list';
            $data = $this->getJsonData($file);
        }

        return $data;
    }


}