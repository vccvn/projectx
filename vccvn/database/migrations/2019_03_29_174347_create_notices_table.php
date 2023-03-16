<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('created_by')->unsigned()->nullable()->default(0);
            $table->bigInteger('to_id')->nullable()->default(0);
            $table->string('to_group')->nullable();
            $table->string('type')->nullable()->default('personal');
            $table->string('title')->nullable()->default('Bạn có thông báo mới');
            $table->text('message')->nullable();
            $table->string('ref')->nullable();
            $table->bigInteger('ref_id')->unsigned()->nullable()->default(0);
            $table->integer('seen')->default(0);
            $table->timestamps();
            
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notices');
    }
}
