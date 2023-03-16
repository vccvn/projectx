<?php

namespace App\Http\Controllers\Traits;

use Crazy\Helpers\Arr;
use Illuminate\Http\Request;


/**
 * các thuộc tính và phương thức của form sẽ được triển trong ManagerController
 * @method void beforeGetIndexData(Request $request)
 * @method void beforeGetIndexView(Request $request, Arr $data)
 * @method void beforeGetListData(Request $request)
 * @method void beforeGetListView(Request $request, Arr $data)
 * @method void beforeGetTrashData(Request $request) 
 * @method void beforeGetTrashView(Request $request, Arr $data)
 * @method void beforeGetDetailData(Request $request) 
 * @method void beforeGetDetailView(Request $request, Arr $data)
 * @method void beforeGetCreateForm(Request $request, Arr $config, Arr $inputs, Arr $data , Arr $attribues)
 * @method void beforeGetUpdateForm(Request $request, Arr $config, Arr $inputs, Arr $data , Arr $attribues)
 */
trait ViewMethods
{
        
    /**
     * @var string $viewFolder thu muc chua view
     * khong nen thay doi lam gi
     */
    protected $viewFolder = null;
    
    /**
     * @var string $index file do data cua ham index
     */
    protected $index = 'index';

    /**
     * @var string $list file do data cua ham list
     */
    protected $list = 'list';

    /**
     * @var string $trash file do data cua ham trash
     */
    protected $trash = 'trash';

    /**
     * @var string $detail ten file blade cua detail
     */
    protected $detail = 'detail';

    /**
     * @var string $form blade name
     */
    protected $form = 'form';

    /**
     * @var string $alert blade name
     */
    protected $alert = 'alert';

    /**
     * @var string $error blade name
     */
    protected $error = 'errors';


    protected $viewEvents = [
        
    ];

    /**
     * bắt sự kiện
     * @param string $event
     * @param array ...$params
     * @return mixed
     */
    public function callViewEvent(string $event, ...$params)
    {
        if(method_exists($this, $event)){
            return call_user_func_array([$this, $event], $params);
        }
        $a = $this->fire($event, ...$params);

        return null;
    }

    /**
     * view
     * @param string $bladePath
     * @param array $data
     * @return ViewEngin
     */
    public function view(string $bladePath, array $data = [])
    {
        $d = $this->viewFolder . '.';

        $bp = $d . $bladePath;

        $a = explode('.', $bp);
        $b = array_pop($a);
        $current = implode('.', $a) . '.';
        $viewdata = array_merge($data, [
            '_component' => $d . '_components.', // blade path to folder contains all of components
            '_template' => $d . '_templates.',
            '_pagination' => $d . '_pagination.',
            '_layout' => $d . '_layouts.',
            '_current' => $current,
            '_base' => $d,
            'module_slug' => $this->module,
            'module_name' => $this->moduleName,
            'route_name_prefix' => $this->routeNamePrefix
        ]);
        return view($bp, $viewdata);
    }

    /**
     * giống view nhung trỏ sẵn vào module
     * @param string $bladeName
     * @param array $data dữ liệu truyền vào
     */
    public function viewModule($subModule, array $data = [])
    {
        return $this->view($this->moduleBlade . '.' . $subModule, $data);
    }

    /**
     * lấy danh sách 
     * @param Request $request
     * @param array $params
     * @param array $variable
     * @return View
     */
    public function getFlashModeListData(Request $request, array $params = [], array $variable = [])
    {
        $this->callViewEvent('beforeGetListData', $request);
        $data = [];
        $data['results'] = $this->getResults($request, $params);
        $arrData = new Arr($data);
        $this->callViewEvent('beforeGetListView', $request, $arrData);
        $config = new Arr($this->getListConfigData());
        $viewData = $arrData->all();
        $viewData['config'] = $config;
        $viewShareData = array_merge(['list_group' => 'default'], $variable, $viewData);
        
        return $this->view('_module.list', $viewShareData);
    
    }

    /**
     * Hiển thị danh sách các kết quar tim dc
     * @param Request $request
     * @return View
     */
    public function getIndex(Request $request)
    {
        if($this->flashMode){
            return $this->getFlashModeListData($request, [], ['list_group' => 'default']);
        }
        
        $this->callViewEvent('beforeGetIndexData', $request);
        $data = [];
        $data['results'] = $this->getResults($request);
        $arrData = new Arr($data);
        $this->callViewEvent('beforeGetIndexView', $request, $arrData);
        // co the code them =))))))

        return $this->viewModule($this->index, $arrData->all());
    }

    /**
     * Hiển thị danh sách các kết quar tim dc
     * @param Request $request
     * @return View
     */
    function getList(Request $request) {
        $this->activeMenu($this->module.'.list');
        if($this->flashMode){
            return $this->getFlashModeListData($request, [], ['list_group' => 'default']);
        }
        $this->callViewEvent('beforeGetListData', $request);
        $data = [];
        $data['results'] = $this->getResults($request);
        $arrData = new Arr($data);
        $this->callViewEvent('beforeGetListView', $request, $arrData);
        
        // co the code them =))))))

        return $this->viewModule($this->list, $arrData->all());
    }

    
    /**
     * Hiển thị danh sách các kết quar tim dc
     * @param Request $request
     * @return View
     */
    function getDetail(Request $request, $id = null) {
        $this->repository->notTrashed();
        if($this->flashMode){
            return $this->getFlashModeDetailData($request);
        }
        $this->callViewEvent('beforeGetDetailData', $request);
        
        if($id && $detail = $this->repository->getDetail(['id'=>$id])){
            $data = [];
            $data['detail'] = $detail;
            $arrData = new Arr($data);
            $this->callViewEvent('beforeGetDetailView', $request, $arrData);
            return $this->viewModule($this->detail, $arrData->all());
        }

        // co the code them =))))))
        return $this->showError($request, 404, "Mục này không tồn tại hoặc đã bị xóa");
    }


    /**
     * Hiển thị danh sách Dã bị xóa tạm thời
     * @param Request $request
     * @return View
     */
    function getTrash(Request $request) {
        $this->activeMenu($this->module.'.trash');
        $this->repository->trashed(true);

        $this->callViewEvent('beforeGetTrashData', $request);
        if($this->flashMode){
            return $this->getFlashModeListData($request, [], ['list_group' => 'trash']);
        }
        
        // co the code them =))))))
        $data = [];
        $data['results'] = $this->getResults($request,[]);
        $arrData = new Arr($data);
        $this->callViewEvent('beforeGetTrashView', $request, $arrData);
        
        // co the code them =))))))

        return $this->viewModule($this->trash, $arrData->all());
    }

    /**
     * hiển thị form thêm mới dữ liệu
     * @param Request
     * @return View
     *
     * @override để xử lý
     */
    public function getCreateForm(Request $request)
    {
        $this->activeMenu($this->module.'.create');
        // return $this->viewModule('add-form');
        return $this->getCrudForm($request, ['type'=>'create']);
    }

    /**
     * hiển thị form cập nhật
     * @param Request $request
     * @param int $id
     * @return View
     */
    public function getUpdateForm(Request $request, $id = null)
    {
        $this->repository->notTrashed();
        $keyName = $this->repository->getKeyName();
        if($request->id && $detail = $this->repository->getFormData([$keyName=>$request->id])){
            $this->repository->setActiveID($detail->id);
            $this->activeMenu($this->module.'.update');
            return $this->getCrudForm($request, ['type'=>'update'], $detail);
        }
        return $this->showError($request, 404, "Mục này không tồn tại hoặc đã bị xóa");
    }

    
    /**
     * hiển thị form thêm mới dữ liệu
     * @param Request
     * @return View
     *
     * @override để xử lý
     */
    public function getFreeForm(Request $request)
    {
        return $this->getForm($request, ['type'=>'free']);
    }


    /**
     * hiển thị lỗi
     * @param Request $request
     * @param int $code error code
     * @param string $message
     * @return View
     */
    public function showError(Request $request, $code=404, $message = "")
    {
        if(!$message && $request->message) $message = $request->message;
        $code = in_array($code,[403, 404, 500])?$code:404;
        return $this->view($this->error.'.'. $code, compact('message'));
    }

    /**
     * hiển thị lỗi
     * @param string $message
     * @return View
     */
    public function alert($message = null, $type = null)
    {
        return $this->view('alert.message', compact('message', 'type'));
    }

    

}