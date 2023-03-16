<?php

namespace App\Console\Commands;

use App\Exceptions\NotReportException;
use App\Repositories\Crawlers\PostTaskRepository;
use App\Repositories\Crawlers\ProductTaskRepository;
use App\Repositories\Crawlers\TaskRepository;
use Illuminate\Console\Command;

use Crazy\Apis\Api;
use Crazy\Files\Filemanager;

class CrazyTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crazy:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Thực hiện tác vụ nào đó ';


    /**
     * repository chinh
     *
     * @var TaskRepository
     */
    public $repository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TaskRepository $repository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $crawl = new PostTaskRepository();
            $crawlProduct = new ProductTaskRepository();
            $fileManager = new Filemanager();
            try {
                $crawl->task();
                $crawlProduct->task();
                $msg = "Chạy task lúc " . date("Y-m-d H:i:s");
                $fileManager->append("\n" . $msg, storage_path('crazy/logs/' . date('Y-m-d') . '.log'));
            } catch (NotReportException $th) {
                $msg = "Lỗi không xác định. time: " . date("Y-m-d H:i:s");
                $fileManager->append("\n" . $msg, storage_path('crazy/logs/' . date('Y-m-d') . '.log'));
            }
            $this->info($msg);
        } catch (NotReportException $th) {
            $this->info("Lỗi không xác định");
        }
    }
}
