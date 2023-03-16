<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->nullable()->default(0);
            $table->string('data_group')->nullable()->default('data');
            $table->string('ref')->nullable()->default('data');
            $table->string('name')->nullable()->default('name');
            $table->text('value')->nullable();
            $table->string('type')->nullable()->default('text');
            $table->string('label')->nullable()->default('Nhãn');
            
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
        Schema::dropIfExists('web_data');
    }
}
