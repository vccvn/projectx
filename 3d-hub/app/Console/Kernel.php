<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Repositories\Crawlers\PostTaskRepository;
use App\Repositories\Crawlers\ProductTaskRepository;
use Crazy\Files\Filemanager;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CrazyTask::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $msg = "Chạy task lúc " . date("Y-m-d H:i:s");
        $fileManager->append("\n".$msg, storage_path('crazy/logs/task.log'));
        $schedule->call(function(){
            $crawl = new PostTaskRepository();
            $crawl->task();
            $crawlProduct = new ProductTaskRepository();
            $crawlProduct->task();
            $fileManager = new Filemanager();
            $msg = "Chạy task lúc " . date("Y-m-d H:i:s");
            $fileManager->append("\n".$msg, storage_path('crazy/logs/task.log'));
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
