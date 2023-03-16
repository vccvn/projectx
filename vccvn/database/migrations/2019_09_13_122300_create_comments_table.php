<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('parent_id')->unsigned()->nullable()->default(0);
            $table->string('ref')->nullable()->default('post');
            $table->bigInteger('ref_id')->unsigned()->nullable()->default(0);
            $table->string('author_name')->nullable();
            $table->string('author_email')->nullable();
            $table->string('author_phone')->nullable();
            $table->string('author_website')->nullable();
            $table->bigInteger('author_id')->unsigned()->nullable()->default(0);
            $table->text('message')->nullable();
            $table->boolean('approved')->nullable()->default(false);
            $table->bigInteger('approved_id')->unsigned()->nullable()->default(0);
            $table->string('privacy')->nullable()->default('public');
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
        Schema::dropIfExists('comments');
    }
}
