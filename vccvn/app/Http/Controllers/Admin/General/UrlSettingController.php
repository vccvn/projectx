<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Admin\AdminController;

use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Options\UrlSettingRepository;

class UrlSettingController extends AdminController
{
    protected $module = 'settings';

    protected $moduleName = 'Thiết lập Url';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var UrlSettingRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UrlSettingRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }
    public function getUrlSettingForm(Request $request)
    {
        //
        if(!($urlGroups = $this->repository->getSettingData())) {
            return $this->showError($request, 404, 'Mục này không tồn tại');
        }
        $this->activeMenu('urls');
        $tab = $request->group;
        return $this->viewModule('urls', compact('urlGroups', 'tab'));

    }


    /**
     * THÊM ITEM
     *
     * @param Request $request
     * @param string $group
     * @return JSON
    */
    public function saveSettings(Request $request, $group = null)
    {
        $validator = $this->repository->validator($request, 'Settings\UrlSettingValidator');
        if(!$validator->success()){
            return redirect()->back()->withErrors($validator->getErrorObject())->withInput();
        }
        // tao doi tuong data de de truy cap phan tu

        $data = new Arr($validator->inputs());

        // $theme = get_active_theme()??(new Arr(['slug' => 'theme-data', 'id' => 0]));

        $fileList = $this->repository->getUrlOptionItems($request->route('group'), ['type' => 'file']);

        if(count($fileList)){
            foreach($fileList as $item){
                $this->uploadAttachFile($request, $data, $item->name, 'static/users/'.get_secret_id().'/urlsettings/'.$request->route('group'));
            }
        }
        // cập nhật danh sách
        $redirect = redirect()->route($this->routeNamePrefix . 'settings.urls.group', ['group' => $request->route('group')]);
        if(!$this->repository->updateUrlOptionData($request->route('group'), $data->all())){
            $redirect->with('error', "Lỗi không xác định");
        }else{
            $redirect->with('success', "Cập nhât dữ liệu thành công!");
        }
        return $redirect;
    }

}
