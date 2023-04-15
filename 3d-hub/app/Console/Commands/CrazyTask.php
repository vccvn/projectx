<?php

namespace App\Console\Commands;

use App\Exceptions\NotReportException;
use Illuminate\Console\Command;

use Crazy\Apis\Api;

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
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
            $api = new Api();
            $api->setResponseType("json");
            $a = $api->get('http://api.chinhlatoi.vn/tasks/crawl', ['s' => rand(0, 1990)]);
            $msg = "Chạy task lúc " . date("Y-m-d H:i:s") . ": ".json_encode($a);
            $this->info($msg);
        } catch (NotReportException $th) {
            $this->info("Lỗi không xác định");
        }
    }
}
