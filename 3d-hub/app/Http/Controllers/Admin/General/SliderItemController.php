<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;
use App\Repositories\Sliders\ItemRepository;
use App\Repositories\Sliders\SliderRepository;

class SliderItemController extends AdminController
{
    protected $module = 'sliders.items';

    protected $moduleName = 'Slider Item';

    /**
     * @var string $redirectRoute route đề chuyển hướng khi luu data
     */
    protected $redirectRoute = 'sliders.items.update';
    /**
     * slider
     *
     * @var App\Models\Slider
     */
    protected $slider = null;
    // protected $flashMode = true;


    /**
     * Slider Repository
     *
     * @var SliderRepository
     */
    public $repository = null;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ItemRepository $ItemRepository)
    {
        $this->repository = $ItemRepository;
        $this->init();
    }

    public function start()
    {
        $this->activeMenu('sliders');
        admin_breadcrumbs([
            [
                'url' => route($this->routeNamePrefix . 'sliders.list'),
                'text' => 'Slider'
            ]
        ]);
    }

    public function addSliderId()
    {
        if($id = get_slider_active_id()){
            $this->repository->addDefaultValue('slider_id', $id);
            $this->repository->addDefaultParam('slider_id', $id);
        }
    }

    public function addBreadcrumb()
    {
        if ($slider = get_web_data('slider')) {
            $this->slider = $slider;
            admin_breadcrumbs([
                [
                    'url' => admin_slider_item_url('list'),
                    'text' => $slider->name
                ],
                [
                    'url' => admin_slider_item_url('create'),
                    'text' => 'Thêm item'
                ]
            ]);
        }
    }

    public function beforeGetIndexData()
    {
        $this->addSliderId();
        $this->addBreadcrumb();
    }
    public function beforeGetListData()
    {
        $this->addSliderId();
        $this->addBreadcrumb();
    }

    /**
     * chuan bi truoc cho hiển thị crud form
     * @param Request $request
     * @param Arr $config
     * @param Arr $attrs
     *
     * @return void
     */
    public function prepareGetCrudForm(Request $request, Arr $config, Arr $attrs)
    {
        $this->addBreadcrumb();
        $this->cancelButtonUrl = admin_slider_item_url('list');
        $attrs->action = admin_slider_item_url('save');
    }


    /**
     * thêm thông tin vào form
     *
     * @param Request $request
     * @param Arr $config
     * @param Arr $inputs
     * @return void
     */
    public function beforeGetCrudForm(Request $request, Arr $config, Arr $inputs)
    {
        // nếu slider cố định kích thước ảnh
        if ($this->slider->crop) {
            $inputs->image = array_merge($inputs->image, [
                'template' => 'cropit',
                'data-width' => $this->slider->width,
                'data-height' => $this->slider->height,
            ]);
        }
    }



    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, $data)
    {
        // upload và cap nhật file ành
        $this->uploadImageAttachFile($request, $data, 'image', 'static/sliders');
    }



    /**
     * can thiệp sau khi luu
     * @param Illuminate\Http\Request $request
     * @param App\Models\Model $model bản ghi sau khi được lưu trữ
     * @return void
     */
    public function afterSave(Request $request, $result, $data)
    {
        // thay đổi route chuyển hướng
        $this->redirectRouteParams = [
            'slider' => $request->route('slider'),
            'id' => $result->id
        ];
    }



    /**
     * Hiển thị form sap xep
     * 
     * @param Request $request
     * @return View
     */
    function getSortForm(Request $request)
    {
        $this->addBreadcrumb();
        $list = $this->repository->get();
        return $this->viewModule('sort', compact('list'));
    }


    /**
     * sắp xếp slider
     *
     * @param Request $request
     * @return void
     */
    public function sortItems(Request $request)
    {
        extract($this->apiDefaultData);

        // validate
        $validator = $this->repository->validator($request, 'Sliders\SortItemsValidator');
        if (!$validator->success()) {
            $message = 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            $errors = $validator->errors();
        } elseif (!$this->repository->sortSliders($request->data)) {
            $message = 'Lỗi không xác định. Vui lòng thử lại sau giây láy';
        } else {
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }
}
