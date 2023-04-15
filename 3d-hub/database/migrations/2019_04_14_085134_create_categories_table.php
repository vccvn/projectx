<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
           
            $table->bigInteger('dynamic_id')->unsigned()->default(0);
            $table->bigInteger('parent_id')->unsigned()->default(0);
            $table->string('name');
            $table->string('type')->default('post');
            $table->string('slug');
            $table->string('keywords')->nullable();
            $table->text('description')->nullable();
            $table->string('feature_image')->nullable();
            $table->integer('deleted')->default(0);
            $table->timestamps();

            // $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('dynamic_id')->references('id')->on('dynamics')->onDelete('cascade');
            // $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
