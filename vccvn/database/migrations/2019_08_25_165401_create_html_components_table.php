<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHtmlComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('html_components', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('component_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('area_id')->nullable()->default(0);
            $table->bigInteger('parent_id')->nullable()->default(0);
            $table->integer('priority')->unsigned()->default(0);
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
        Schema::dropIfExists('html_components');
    }
}
