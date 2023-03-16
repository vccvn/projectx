<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('user_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('customer_id')->unsigned()->nullable()->default(0);
            $table->string('secret_id')->nullable();
            $table->string('type')->nullable()->default('cart');
            $table->boolean('ship_to_different_address')->default(false);
            $table->bigInteger('payment_method_id')->default(0);
            $table->decimal('shipping_fee', 10, 2)->default(0);
            $table->decimal('tax', 14, 2)->default(0);
            $table->decimal('sub_total', 14, 2)->default(0);
            $table->decimal('total_money', 14, 2)->default(0);
            $table->text('note')->nullable();
            $table->integer('status')->default(0);
            $table->integer('deleted')->default(0);
            $table->dateTime('completed_at')->nullable();
            $table->timestamp('ordered_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
