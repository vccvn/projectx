<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryRefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_refs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned()->default(0);
            $table->string('ref')->nullable();
            $table->bigInteger('ref_id')->unsigned()->default(0);
            
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_refs');
    }
}
