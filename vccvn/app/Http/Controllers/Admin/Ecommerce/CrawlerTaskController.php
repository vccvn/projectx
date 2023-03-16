<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;
use App\Repositories\Crawlers\ProductTaskRepository;
use Crazy\Helpers\Arr;

class CrawlerTaskController extends AdminController
{
    public $module = 'products.crawlers.tasks';

    public $moduleName = 'Task';

    /**
     * repo chinh
     *
     * @var ProductTaskRepository
     */
    public $repository;
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProductTaskRepository $taskRepository)
    {
        $this->repository = $taskRepository;
        $this->init();

        admin_breadcrumbs([
            [
                'url' => $this->getModuleRoute('list'),
                'text' => 'Task'
            ],
        ]);
        
    }

    
    /**
     * làm gì đó trước khi xuất view
     * 
     */
    public function beforeGetCrudForm(){
        add_js_src('static/manager/js/crawler.js');
        admin_breadcrumbs([
            [
                'url' => $this->getModuleRoute('create'),
                'text' => 'Thêm Task'
            ]
        ]);
        
    }

    
    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, Arr $data)
    {
        $data->status = $data->status ==  'on' ? 1: 0;

        $data->crawl_resources = $data->crawl_resources ? 1 : 0;
        $data->config = $data->copy($this->repository->getConfigFields());
        // dd($data);
    }

    /**
     * thay doi trang thái của task
     * @param Request $request thông tin request
     * 
     * @return Response::json
     */
    public function changeStatus(Request $request)
    {
        extract($this->apiDefaultData);
        if($request->id && $result = $this->repository->changeStatus($request->id, $request->status)){
            $status = true;
            $data = $result;
        }    
        return $this->json(compact(...$this->apiSystemVars));
    }


    /**
     * thực thi task
     * @param Request $request thông tin request
     * 
     * @return Response::json
     */
    public function run(REquest $request){
        extract($this->apiDefaultData);
        $count = 0;
        $list = []; 
        $data = [];
        if(is_array($request->ids) && count($request->ids)){
            $t = count($crawl_list = $this->repository->runMany($request->ids));
            $list = $crawl_list;
            foreach($crawl_list as $taskDAta)
            {
                $count+=$taskDAta;
            }
            $status = true;
        }
        else{
            $message = "Lỗi không xác định";
        }
        $data = compact('count', 'list');
        Session::flash('count', $count);
        return $this->json(compact(...$this->apiSystemVars));

    }

}
