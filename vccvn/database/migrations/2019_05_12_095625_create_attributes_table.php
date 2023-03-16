<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->default(0);
            $table->bigInteger('category_id')->unsigned()->default(0);
            $table->string('category_map')->nullable();
            $table->string('name')->nullable();
            $table->string('label')->nullable();
            $table->string('input_type')->nullable()->default('default');
            $table->string('value_type')->nullable()->default('varchar');
            $table->string('advance_value_type')->nullable()->default('default');
            $table->string('show_type')->nullable()->default('dropdown');
            $table->string('value_unit', 32)->nullable();
            $table->integer('is_required')->nullable()->default(0);
            $table->integer('is_query')->nullable()->default(0);
            $table->integer('is_order_option')->nullable()->default(0);
            $table->integer('is_variant')->nullable()->default(0);
            $table->integer('has_price')->nullable()->default(0);
            $table->integer('price_type')->nullable()->default(0);
            $table->integer('is_unique')->nullable()->default(0);
            $table->integer('use_list')->nullable()->default(0);
            
            
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('attributes');
    }
}
