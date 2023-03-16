<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Options\SettingRepository;
use App\Repositories\Options\GroupRepository;
use App\Repositories\Options\DataRepository;

class SettingController extends AdminController
{
    protected $module = 'settings';

    protected $moduleName = 'Thiết lập';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SettingRepository $SettingRepository, GroupRepository $groupRepository, DataRepository $dataRepository)
    {
        $this->repository = $SettingRepository;
        $this->groupRepository = $groupRepository;
        $this->dataRepository = $dataRepository;
        $this->init();
    }

    
    public function addViewGroupData($group)
    {
        $this->activeMenu($this->module.'.'.$group);
        // $this->activeMenu($this->module.'.list');
        $params = compact('group');
        add_js_data('setting_data', [
            'urls' => [
                'sort' => $this->getModuleRoute('sort.save', $params),
                'delete' => $this->getModuleRoute('item.delete', $params),
                'detail' => $this->getModuleRoute('item.detail', $params)
            ],
        ]);

        add_js_data('posts_data', [
            'urls' => [
                'get_category_url' => route($this->routeNamePrefix.'posts.category-options')
            ],
        ]);

        
        admin_action_menu([
            [
                'url' => $this->getModuleRoute('group.form', $params),
                'text' => 'Form',
                'icon' => 'fa fa-tasks'
            ],
            [
                'url' => $this->getModuleRoute('sort.form', $params),
                'text' => 'Sắp xếp',
                'icon' => 'fa fa-sort-amount-down'
            ]
        ]);
    }


    /**
     * Hiển thị form option
     * @param Request $request
     * @param string $group
     * @return View
     */
    public function getSettingForm(Request $request, $group = null)
    {
        if(!($fdata = $this->repository->getSettingFormData($group))) return $this->showError($request, 404);
        $this->submitUrl = $this->getModuleRoute('group.save',['group'=>$group]);
        $this->btnSubmitEext = 'Lưu';
        $this->addViewGroupData($group);
        if(count($fdata['inputs'])){
            foreach ($fdata['inputs'] as $key => $input) {
                if(isset($input['type'])){
                    if($input['type'] == 'maillist'){
                        $input['type'] = 'textarea';
                    }
                }
                $fdata['inputs'][$key] = $input;
            }
        }
        return $this->getForm($request, [
            'type' => 'free',
            'input_type' => 'list',
            'inputs' => $fdata['inputs'],
            'form_config' => [
                'title' => $fdata['group_label'],
                'lock_style' => true
            ]
        ],$fdata['data']);
    }

    /**
     * lằng nghe sự kiện của hàm handle khi đã hoàn thành
     * @param Request $request
     * @param Arr $data dữ liệu đã được validate
     *
     * @return void
     */
    public function done(Request $request, Arr $data)
    {
        // lấy danh sách data có trong group với loại input là file
        $fileList = $this->repository->getSettingItems($request->route('group'), ['type' => 'file']);
        if(count($fileList)){
            // dd($fileList);
            foreach($fileList as $item){
                $this->uploadAttachFile($request, $data, $item->name, get_content_path('settings/'.$request->route('group')));
            }
        }
        // cập nhật danh sách
        $this->repository->updateSettingData($request->route('group'), $data->all());
        
    }


    
    
    /**
     * Hiển thị form sap xep
     * 
     * @param Request $request
     * @return View
     */
    function getSortForm(Request $request, $group) {
        $list = $this->repository->getSettingItems($request->route('group'));
        if(!count($list)) return $this->showError($request, 404);
        $this->addViewGroupData($group);
        $optionTitle = $this->repository->currentOptionTitle;
        $groupLabel = $this->repository->currentGroupLabel;

        return $this->viewModule('sort', compact('list', 'optionTitle', 'groupLabel', 'group'));
    }

    
    /**
     * sắp xếp items
     *
     * @param Request $request
     * @return void
     */
    public function sortItems(Request $request)
    {
        extract($this->apiDefaultData);

        // validate
        if (!($group = $this->repository->getSettingGroup($request->route('group')))){
            $message = 'Thông tin không hợp lệ';
        }
        elseif (!($validator = $this->dataRepository->validator($request, 'Options\SortSettingItemValidator')) || !$validator->success()){
            $message = 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            $errors = $validator->errors();
        }
        elseif (!$this->dataRepository->sortItems($group->id, $request->data)) {
            $message = 'Lỗi không xác định. Vui lòng thử lại sau giây láy';
        }
        else{
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    /**
     * THÊM ITEM
     *
     * @param Request $request
     * @param string $group
     * @return JSON
    */
    public function saveSettingItem(Request $request, $group)
    {
        extract($this->apiDefaultData);

        // validate
        if (!($group = $this->repository->getSettingGroup($request->route('group')))){
            $message = 'Thông tin không hợp lệ';
        }
        elseif (!($validator = $this->repository->validator($request, 'Options\SaveSettingItemValidator')) || !$validator->success()){
            $message = 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            $errors = $validator->errors();
        }
        elseif (!($item = $this->dataRepository->save(array_merge($validator->inputs(), ['group_id' => $group->id, 'can_delete' => 1]), $request->id))) {
            $message = 'Lỗi không xác định. Vui lòng thử lại sau giây láy';
        }
        else{
            $data = $item;
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    
    /**
     * THÊM ITEM
     *
     * @param Request $request
     * @param string $group
     * @return JSON
    */
    public function deleteItem(Request $request, $group)
    {
        extract($this->apiDefaultData);

        // validate
        if (!($group = $this->repository->getSettingGroup($request->route('group')))){
            $message = 'Thông tin không hợp lệ';
        }
        elseif (!($item = $this->dataRepository->first(['group_id' => $group->id, 'can_delete' => 1, 'id'=>$request->id]))) {
            $message = 'Lỗi không xác định.';
        }
        elseif(!$this->dataRepository->delete($item->id)){
            $message = 'Lỗi không xác định. Vui lòng thử lại sau giây láy';
        }
        else{
            $data = [$request->id];
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

    
    /**
     * THÊM ITEM
     *
     * @param Request $request
     * @param string $group
     * @return JSON
    */
    public function detailItem(Request $request, $group, $id = null)
    {
        extract($this->apiDefaultData);

        // validate
        if (!($group = $this->repository->getSettingGroup($request->route('group')))){
            $message = 'Thông tin không hợp lệ';
        }
        elseif (!($item = $this->dataRepository->first(['group_id' => $group->id, 'can_delete' => 1, 'id'=>$request->id]))) {
            $message = 'Lỗi không xác định.';
        }
        else{
            $data = $item;
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }

}
