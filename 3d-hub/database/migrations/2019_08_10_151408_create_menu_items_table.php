<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('menu_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->nullable()->default(0);
            $table->integer('priority')->unsigned()->default(0);
            $table->string('type')->nullable()->default('default'); // default, route, category, dynamic, page
            $table->string('ref')->nullable();
            $table->bigInteger('ref_id')->unsigned()->nullable()->default(0);
            $table->string('sub_type')->nullable()->default('default'); // default, categories, dynamics, pages, mega
            $table->json('props')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}
