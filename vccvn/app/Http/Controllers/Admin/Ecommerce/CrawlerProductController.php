<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Crawlers\ProductFrameRepository;
use App\Repositories\Crawlers\CrawlProductRepository;
use App\Repositories\Posts\CategoryRepository;
use App\Repositories\Dynamics\DynamicRepository;
use Crazy\Helpers\Arr;

class CrawlerProductController extends AdminController
{
    public $module = 'products.crawlers.crawl';

    public $moduleName = 'Crawl Sản phẩm';

    protected $submitRoute = 'admin.products.crawlers.handle';

    /**
     * Undocumented variable
     *
     * @var CrawlProductRepository $repository
     */
    public $repository;
    
    public $frames;

    public $categories;

    public $dynamics;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        CrawlProductRepository $CrawlProductRepository,
        ProductFrameRepository $FrameRepository, 
        DynamicRepository $dynamicRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->repository = $CrawlProductRepository;
        $this->frames = $FrameRepository;
        $this->dynamics = $dynamicRepository;
        $this->categories = $categoryRepository;
        $this->init();
        
    }

    /**
     * làm gì đó trước khi xuất view
     * 
     */
    public function beforeGetForm(){
        add_js_src('static/manager/js/crawler.js');
        // add_js_data('crawler_urls', [
        //     'get_category_url' => $this->getModuleRoute('category-options')
        // ]);
    }

    
    /**
     * ham nay se được gọi sau khi validate thành công
     * @param Request $request http request
     * @param Arr $data dữ liệu sau khi được validate
     * 
     * @return mixed redirect hoặc view
     */
    public function done(Request $request, Arr $data)
    {
        if(!$data->shop_id) $data->shop_id = $request->user()->id;
        if($product = $this->repository->crawl($data->all())){
            return redirect()->back()->withInput()->with('success', 'Crawl sản phẩm thành công!');
        }
        return redirect()->back()->withInput()->with('error', 'Lỗi không xác định');
    }

}
