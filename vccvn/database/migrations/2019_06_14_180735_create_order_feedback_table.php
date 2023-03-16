<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_feedback', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('order_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('user_id')->unsigned()->nullable()->default(0);
            $table->string('type')->default('feedback');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            
            $table->integer('solved')->default(0);
            $table->dateTime('solved_at')->nullable();
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
        Schema::dropIfExists('order_feedback');
    }
}
