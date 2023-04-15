<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrazy3dModelItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crazy_3d_model_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->default(0);
            $table->bigInteger('category_id')->unsigned()->default(0);
            $table->string('name')->nullable()->default('untitiled');
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->string('status')->nullable()->default('draft');
            $table->string('secret_id')->nullable();
            // model 3d
            $table->string('type')->nullable();
            $table->string('path')->nullable();
            $table->string('file')->nullable();
            $table->string('download_url')->nullable();
            $table->string('zip_file')->nullable();
            $table->string('thumbnail')->nullable();
            
            $table->json('__data__')->nullable();
            
            $table->integer('deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crazy_3d_model_items');
    }
}
