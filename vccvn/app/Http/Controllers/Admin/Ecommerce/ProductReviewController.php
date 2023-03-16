<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use Crazy\Helpers\Arr;
use App\Repositories\Products\ReviewRepository;

class ProductReviewController extends AdminController
{
    protected $module = 'products.reviews';

    protected $moduleName = 'Đánh giá sàn phẩm';

    protected $flashMode = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->repository = $reviewRepository;
        $this->init();
        $this->activeMenu('products');
        $this->addHeaderButtons('create');
    }

}
