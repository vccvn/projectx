<?php

namespace App\Http\Controllers\Apis;

use App\Exceptions\NotReportException;
use App\Http\Controllers\Apis\ApiController;
use App\Repositories\Crawlers\PostTaskRepository;
use App\Repositories\Crawlers\ProductTaskRepository;
use Illuminate\Http\Request;
use Crazy\Helpers\Arr;

use App\Repositories\Crawlers\TaskRepository;
use Crazy\Files\Filemanager as FilesFilemanager;
use Filemanager;

class TaskController extends ApiController
{
    protected $module = 'tasks';

    protected $moduleName = 'Task';

    protected $flashMode = true;

    /**
     * repository chinh
     *
     * @var TaskRepository
     */
    public $repository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
        $this->init();
    }

    public function crawl(Request $request)
    {

        $crawl = new PostTaskRepository();
        $crawlProduct = new ProductTaskRepository();
        $fileManager = new FilesFilemanager();
        try{
            $crawl->task();
            $crawlProduct->task();
            $msg = "Chạy task lúc " . date("Y-m-d H:i:s");
            $fileManager->append("\n".$msg, storage_path('crazy/logs/'.date('Y-m-d').'.log'));
        } catch(NotReportException $th){
            $msg = "Lỗi không xác định. time: " . date("Y-m-d H:i:s");
            $fileManager->append("\n".$msg, storage_path('crazy/logs/'.date('Y-m-d').'.log'));
        }
        
        return $this->response($msg);
    }

}
