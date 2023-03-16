<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Sliders\SliderRepository;

class SliderController extends AdminController
{
    protected $module = 'sliders';

    protected $moduleName = 'Slider';

    protected $flashMode = true;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SliderRepository $SliderRepository)
    {
        $this->repository = $SliderRepository;
        $this->init();
    }

    /**
     * thêm slug
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function beforeSave(Request $request, Arr $data)
    {
        $data->slug = $this->repository->getSlug($data->slug?$data->slug:$data->name, $request->id);
    }

    
    /**
     * sắp xếp lại vị trí sau khi tạo mới
     *
     * @param Request $request
     * @param App\Models\Slider $result
     * @return void
     */
    public function afterCreate(Request $request, $result)
    {
        $this->repository->updatePriority($result->id, $result->priority);
    }

    public function start()
    {
        // $this->activeMenu($this->module.'.list');
        add_js_data('slider_data', [
            'urls' => [
                'change_status' => $this->getModuleRoute('change-status'),
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
                'text' => 'Sắp xếp slider',
                'icon' => 'fa fa-sort-amount-down'
            ]
        ]);
    }


    /**
     * thay đổi trạng thái slider
     *
     * @param Request $request
     * @return json
     */
    public function changeStatus(Request $request)
    {
        extract($this->apiDefaultData);
        $d = ['status' => $request->slider_status?1:0];
        // return $d;
        if($request->id && $detail = $this->repository->update($request->id, $d)){
            $data = $detail;
            $status = true;
        }
        else{
            $message = 'Không tìm thấy slider';
        }
        return $this->json(compact(...$this->apiSystemVars));
    }



    
    /**
     * Hiển thị form sap xep
     * 
     * @param Request $request
     * @return View
     */
    function getSortForm(Request $request) {
        $sliders = $this->repository->get(['@order_by' => ['priority' => 'ASC']]);
        return $this->viewModule('sort', compact('sliders'));
    }


    /**
     * sắp xếp slider
     *
     * @param Request $request
     * @return void
     */
    public function sortSliders(Request $request)
    {
        extract($this->apiDefaultData);

        // validate
        $validator = $this->repository->validator($request, 'Sliders\SortSliderValidator');
        if(!$validator->success()){
            $message = 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            $errors = $validator->errors();
        }
        elseif (!$this->repository->sortSliders($request->data)) {
            $message = 'Lỗi không xác định. Vui lòng thử lại sau giây láy';
        }
        else{
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }
}
