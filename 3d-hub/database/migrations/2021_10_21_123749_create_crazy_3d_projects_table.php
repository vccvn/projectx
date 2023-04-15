<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrazy3dProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crazy_3d_projects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned()->default(0);
            $table->bigInteger('category_id')->unsigned()->default(0);
            $table->string('name')->nullable()->default('untitiled');
            $table->text('description')->nullable();
            $table->string('keywords')->nullable();
            $table->string('status')->nullable()->default('draft');
            $table->string('secret_id')->nullable();
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
        Schema::dropIfExists('crazy_3d_projects');
    }
}
