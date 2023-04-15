<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
           
            $table->bigInteger('upload_by')->unsigned()->default(0);
            $table->string('sid');
            $table->string('privacy')->default('public');
            $table->string('ref')->nullable();
            $table->bigInteger('ref_id')->unsigned()->default(0);
            $table->bigInteger('folder_id')->unsigned()->default(0);
            $table->string('date_path')->nullable();
            $table->string('filename');
            $table->string('original_filename')->nullable();
            $table->string('filetype')->nullable();
            $table->string('mime')->nullable();
            $table->double('size', 10, 2)->nullable()->default(0.0);
            $table->string('extension')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            // $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('upload_by')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
