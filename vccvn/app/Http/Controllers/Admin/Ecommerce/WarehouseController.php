<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;
use App\Repositories\Products\WarehouseRepository;

class WarehouseController extends AdminController
{
    protected $module = 'products.warehouse';

    protected $moduleName = 'Kho hàng';

    protected $flashMode = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(WarehouseRepository $warehouseRepository)
    {
        $this->repository = $warehouseRepository;
        $this->init();
        $this->activeMenu('products');
        $this->addHeaderButtons('create');
    }

    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeCreate(Request $request, $data)
    {
        $data->staff_id = $request->user()->id;
    }

    /**
     * hiển thị form nhập kho
     * @param Request $request
     * @return view
     */
    public function getImportForm(Request $request)
    {
        return $this->getForm($request,['file' => 'warehouse'], ['type' => 'import']);
    }
}
