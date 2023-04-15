<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            // 
            $table->string('secret_id')->nullable();
            $table->string('name')->nullable()->default('CrazyTheme');
            $table->string('slug')->nullable();
            $table->string('view_type')->nullable()->default('multi-page');
            $table->string('web_types')->nullable();
            $table->double('version', 5, 2)->nullable()->default(1.0);
            $table->text('description')->nullable();
            $table->string('privacy')->nullable()->default('protected');
            $table->string('zip')->nullable();
            $table->string('image')->nullable();
            $table->integer('available')->default(0);
            $table->integer('deleted')->default(0);
            $table->timestamps();
            
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
        Schema::dropIfExists('themes');
    }
}
