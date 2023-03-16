<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->nullable()->default(0);
            $table->string('name')->nullable()->default('Menu');
            $table->string('slug')->nullable();
            $table->string('type')->nullable()->default('default');
            $table->bigInteger('ref_id')->nullable()->default(0);
            $table->integer('priority')->unsigned()->default(0);
            $table->boolean('is_main')->nullable()->default(false);
            $table->string('positions')->nullable();
            $table->integer('depth')->unsigned()->nullable()->default(4);
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
