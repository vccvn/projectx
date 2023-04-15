<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Crawlers\PostFrameRepository;
use App\Repositories\Crawlers\CrawlPostRepository;
use App\Repositories\Posts\CategoryRepository;
use App\Repositories\Dynamics\DynamicRepository;
use Crazy\Helpers\Arr;

class CrawlerPostController extends AdminController
{
    public $module = 'crawlers.posts';

    public $moduleName = 'Crawl Post';

    protected $submitRoute = 'admin.crawlers.posts.handle';

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
        CrawlPostRepository $CrawlPostRepository,
        PostFrameRepository $FrameRepository, 
        DynamicRepository $dynamicRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->repository = $CrawlPostRepository;
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
        add_js_data('crawler_urls', [
            'get_category_url' => $this->getModuleRoute('category-options')
        ]);
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
        if($post = $this->repository->crawl($data->all())){
            return redirect()->back()->withInput()->with('success', 'Crawl bài viết thành công!');
        }
        return redirect()->back()->withInput()->with('error', 'Lỗi không xác định');
    }

    /**
     * lấy danh sách category
     * @param Request $request
     */
    public function getCategoryOptions(Request $request)
    {
        extract($this->apiDefaultData);

        if($request->dynamic_id && $dynamic = $this->dynamics->dynamic($request->dynamic_id)){
            if($dynamic->use_category){
                $status = true;
                if($options = $this->categories->getCategoryOptions(['dynamic_id'=>$dynamic->id])){
                    $data = $options;
                }
            }
        }

        return $this->json(compact(...$this->apiSystemVars));
    }
}
