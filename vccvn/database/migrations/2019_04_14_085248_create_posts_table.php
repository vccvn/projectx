<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->default(0);
            $table->bigInteger('author_id')->unsigned()->default(0);
            $table->bigInteger('dynamic_id')->unsigned()->default(0);
            $table->bigInteger('parent_id')->unsigned()->default(0);
            $table->bigInteger('category_id')->unsigned()->default(0);
            $table->string('category_map')->nullable();
            $table->string('type')->default('post');
            $table->string('content_type')->default('text');
            $table->string('title');
            $table->string('slug');
            $table->string('keywords')->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('feature_image')->nullable();
            $table->integer('views')->default(0);
            $table->string('privacy')->default('public');
            $table->integer('deleted')->default(0);
            $table->timestamps();

            // $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('dynamic_id')->references('id')->on('dynamics')->onDelete('cascade');
            // $table->foreign('parent_id')->references('id')->on('posts')->onDelete('cascade');
            // $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
