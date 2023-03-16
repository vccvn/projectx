<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlerTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawler_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->default(0);
            $table->bigInteger('dynamic_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('frame_id')->unsigned();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('author_id')->unsigned()->default(0);
            $table->string('type')->nullable()->default('post');
            $table->string('task_url')->nullable();
            $table->string('post_url_selector')->nullable();
            $table->integer('quantity')->unsigned()->nullable()->default(0);
            $table->integer('crawl_resources')->nullable()->default(0);
            $table->integer('custom_run_time')->unsigned()->nullable()->default(0);
            $table->string('repeat_time')->nullable();
            $table->string('crawl_time')->nullable();
            $table->dateTime('crawl_datetime')->nullable();
            $table->string('crawl_last_time')->nullable();
            $table->json('config')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();

            // $table->foreign('frame_id')->references('id')->on('frames')->onDelete('cascade');
            // $table->foreign('dynamic_id')->references('id')->on('dynamics')->onDelete('cascade');
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            // $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crawler_tasks');
    }
}
