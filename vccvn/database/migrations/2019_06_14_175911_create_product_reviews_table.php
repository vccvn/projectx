<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned()->nullable()->default(0);
            $table->integer('rating')->unsigned()->default(0);
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            // $table->string('title')->nullable();
            $table->text('comment')->nullable();
            $table->integer('approved')->unsigned()->default(0);
            $table->bigInteger('approved_id')->unsigned()->nullable()->default(0);
            
            $table->timestamps();

            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_reviews');
    }
}
