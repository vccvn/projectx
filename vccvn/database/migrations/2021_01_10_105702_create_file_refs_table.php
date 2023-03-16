<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileRefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_refs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id')->unsigned()->default(0);
            $table->bigInteger('file_id')->unsigned()->default(0);
            $table->bigInteger('ref_id')->unsigned()->default(0);
            $table->string('ref')->nullable();

            // $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_refs');
    }
}
