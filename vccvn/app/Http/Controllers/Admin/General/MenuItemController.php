<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;

use App\Repositories\Menus\ItemRepository;
use App\Repositories\Menus\MenuRepository;

class MenuItemController extends AdminController
{
    protected $module = 'menus.items';

    protected $moduleName = 'Menu Item';

    // protected $flashMode = true;
    
    /**
     * @var string $redirectRoute route đề chuyển hướng khi luu data
     */
    protected $redirectRoute = 'menus.items';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ItemRepository $ItemRepository, MenuRepository $menuRepository)
    {
        $this->repository = $ItemRepository;
        $this->menuRepository = $menuRepository;
        $this->init();
        $this->activeMenu('menus');
    }

    /**
     * hiển thị danh sach item theo menu
     * @param Request $request
     */
    public function getItems(Request $request, $menu_id = null)
    {
        $menu = get_web_data('menu');
        if(!$menu){
            return $this->alert("Menu này không tồn tại", "danger");
        } elseif(!in_array($menu->type, ['default', 'theme'])){
            return $this->alert('Loại menu này không hỗ trợ sắp xếp item', "info");
        }
        $items = $this->repository->getMenuRootItems($menu_id);
        $itemGroups = $this->repository->getInputGroup();
        $p = ['menu_id' => $request->menu_id];
        $urls = [
            'sort' => $this->getModuleRoute('sort', $p),
            'save' => $this->getModuleRoute('ajax-save', $p),
            'delete' => $this->getModuleRoute('delete', $p),
            'detail' => $this->getModuleRoute('detail', $p),
            
        ];
        $theme = get_active_theme();
        return $this->viewModule('list', compact('items', 'itemGroups', 'urls', 'theme'));
    }

    public function beforeGetResourceDetail(Request $request)
    {
        $this->repository->with('children');
    }

    /**
     * xu ly data truoc khi luu
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function beforeSave(Request $request, Arr $data)
    {
        $this->processData($request, $data);
    }
    public function beforeAjaxSave(Request $request, Arr $data)
    {
        $this->processData($request, $data);
    }

    /**
     * xư lý dữ liệu người dùng gửi lên
     *
     * @param Request $request
     * @param Arr $data
     * @return void
     */
    public function processData(Request $request, Arr $data)
    {
        $props = new Arr($data->cutWithout(['type', 'sub_type', 'props']));
        $data->merge($this->repository->getRefData($data->type, $props, $request->id));
        $data->menu_id = $request->menu_id;
        $data->props = $props->all();
    }

    /**
     * xu ly sau khi luu
     *
     * @param Request $request
     * @param \App\Models\MenuItem $result
     * @return void
     */
    public function afterSave(Request $request, $result)
    {
        // thay đổi route chuyển hướng
        $this->redirectRouteParams = [
            'menu_id' => $request->menu_id
        ];
    }


    
    /**
     * sắp xếp item
     *
     * @param Request $request
     * @return JSON
     */
    public function sortItems(Request $request)
    {
        extract($this->apiDefaultData);

        // validate
        $validator = $this->repository->validator($request, 'Menus\SortItemsValidator');
        if(!$validator->success()){
            $message = 'Đã có lỗi xảy ra. Vui lòng kiểm tra lại';
            $errors = $validator->errors();
        }
        elseif (!($result = $this->repository->sortItems($request->items))) {
            $message = 'Lỗi không xác định. Vui lòng thử lại sau giây láy';
        }
        else{
            $data = $result;
            $status = true;
        }
        return $this->json(compact(...$this->apiSystemVars));
    }


}
