<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            
            $table->string('type')->nullable()->default('custom');
            $table->string('ref')->nullable();
            $table->bigInteger('ref_id')->unsigned()->nullable()->default(0);
            $table->string('name')->nullable();
            $table->string('path')->nullable();
            $table->text('inputs')->nullable();
            $table->json('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('components');
    }
}
