<?php

namespace App\Http\Controllers\Admin\General;

use App\Engines\JsonData;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Menus\MenuRepository;

class MenuController extends AdminController
{
    protected $module = 'menus';

    protected $moduleName = 'Menu';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MenuRepository $MenuRepository)
    {
        $this->repository = $MenuRepository;
        $this->init();
    }

    public function getMenus(Request $request)
    {
        
        // $this->activeMenu($this->module.'.list');
        $form = new JsonData();
        $inputs = [];
        if($formInputs = $form->getData('admin/modules/menus/form')){
            $inputs = $formInputs['second_inputs'];
        }
        $results = $this->getResults($request);
        return $this->viewModule('list', compact('results', 'inputs'));
    }

    public function beforeSave($request, $data)
    {
        $data->slug = $data->slug?$data->slug:str_slug($data->name);
    }
    /**
     * sap xep lai thu tu
     *
     * @param Request $request
     * @param \App\Models\Menu $result
     * @return void
     */
    public function afterCreate(Request $request, $result)
    {
        $this->repository->updatePriority($result->id);
        if($result->type == 'default'){
            $this->redirectRoute = $this->module . '.items';
            $this->redirectRouteParams = [
                'menu_id' => $result->id
            ];
        }else{
            $this->redirectRoute = $this->module;
        }
    }



    
    public function start()
    {
        // $this->activeMenu($this->module.'.list');
        add_js_data('menu_form_data', [
            'urls' => [
                'sort' => $this->getModuleRoute('sort.save'),
                'delete' => $this->getModuleRoute('delete')
            ],
        ]);
        admin_action_menu([
            [
                'url' => $this->getModuleRoute('list'),
                'text' => 'Danh sách',
                'icon' => 'fa fa-th-list'
            ],
            [
                'url' => $this->getModuleRoute('sort.form'),
                'text' => 'Sắp xếp Menu',
                'icon' => 'fa fa-sort-amount-down'
            ]
        ]);
    }

    
    /**
     * Hiển thị form sap xep
     * 
     * @param Request $request
     * @return View
     */
    function getSortForm(Request $request) {
        $menus = $this->repository->get(['@order_by' => ['priority' => 'ASC']]);
        return $this->viewModule('sort', compact('menus'));
    }


    /**
     * sắp xếp Menu
     *
     * @param Request $request
     * @return void
     */
    public function sortMenus(Request $request)
    {
        extract($this->apiDefaultData);

        // validate
        $validator = $this->repository->validator($request, 'Menus\SortMenuValidator');
        if(!$validator->success()){
            $message = 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            $errors = $validator->errors();
        }
        elseif (!$this->repository->sortMenus($request->data)) {
            $message = 'Lỗi không xác định. Vui lòng thử lại sau giây láy';
        }
        else{
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }
}
