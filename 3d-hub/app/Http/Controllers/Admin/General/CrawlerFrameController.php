<?php

namespace App\Http\Controllers\Admin\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

use App\Repositories\Crawlers\PostFrameRepository;

use Crazy\Helpers\Arr;

class CrawlerFrameController extends AdminController
{
    public $module = 'crawlers.frames';

    public $moduleName = 'Nguồn';

    public $repository;
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PostFrameRepository $FrameRepository)
    {
        $this->repository = $FrameRepository;

        $this->init();
        
    }

        /**
     * chuan bi truoc cho hiển thị crud form
     * @param Request $request
     * @param Arr $config
     * @param Arr $attrs
     * @param Arr $vars
     *
     * @return void
     */
    public function prepareGetCrudForm()
    {
        add_css_link('static/manager/css/crawler.frame.min.css');
    }

    
    
    /**
     * can thiệp trước khi luu
     * @param Illuminate\Http\Request $request
     * @param Arr $data dũ liệu đã được validate
     * @return void
     */
    protected function beforeSave(Request $request, Arr $data)
    {
        $data->selectors = $data->copy($this->repository->getSelectorFields());
        $this->uploadImageAttachFile($request, $data, 'logo', 'static/crawlers');

    }

}
