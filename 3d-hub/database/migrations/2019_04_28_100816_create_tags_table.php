<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            
            $table->string('name')->nullable();
            $table->string('name_lower')->nullable();
            $table->string('keyword')->nullable();
            $table->string('slug')->nullable()->default('undefined');
            $table->integer('tagged_count')->unsigned()->nullable()->default(0);

            
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
        Schema::dropIfExists('tags');
    }
}
