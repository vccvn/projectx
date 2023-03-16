<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlerFramesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawler_frames', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->default(0);
            $table->string('type')->nullable()->default('post');
            $table->string('name')->nullable()->default('Frame name');
            $table->string('url')->nullable();
            $table->string('logo')->nullable();
            $table->integer('index')->default(0);
            $table->text('selectors')->nullable();
            $table->integer('deleted')->default(0);
            $table->timestamps();

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
        Schema::dropIfExists('crawler_frames');
    }
}
