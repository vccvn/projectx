<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Promos\PromoRepository;

use Crazy\Helpers\Arr;
use App\Repositories\Products\ProductRefRepository;

class PromoController extends AdminController
{
    protected $module = 'promos';

    protected $moduleName = 'Khuyến mãi';

    protected $flashMode = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PromoRepository $promoRepository, ProductRefRepository $productRefRepository)
    {
        $this->repository = $promoRepository;
        $this->productRefRepository = $productRefRepository;
        $this->init();
    }

    

    /**
     * can thiệp xử lý trước khi lưu
     * @param Illuminate\Http\Request $request
     * @param App\Models\Promo $promo
     * @param Crazy\Helpers\Arr $data
     * 
     * @return void
     */
    public function beforeSave(Request $request, Arr $data)
    {
        $times = $data->times;
        $data->merge([
            'started_at' => $times['from']??date('Y-M-d H:i:s'),
            'finished_at' => $times['to']??date('Y-M-d H:i:s', time()+3600*24*2),
            
        ]);
    }


    /**
     * lưu các dữ liệu liên quan
     * @param Illuminate\Http\Request $request
     * @param App\Models\Promo $promo
     * @param Crazy\Helpers\Arr $data
     * 
     * @return void
     */
    public function afterSave(Request $request, $promo, Arr $data)
    {
        $this->productRefRepository->updateProductRef('promo', $promo->id, $data->products??[]);
    }


 
}
