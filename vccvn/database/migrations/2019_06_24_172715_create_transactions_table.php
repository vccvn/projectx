<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->nullable()->default(0);
            $table->string('ref')->nullable();
            $table->bigInteger('ref_id')->unsigned()->default(0);
            $table->string('type')->nullable()->default('transfer');
            $table->bigInteger('customer_id')->unsigned()->nullable()->default(0);
            $table->string('code')->nullable();
            $table->decimal('amount', 12, 2)->unsigned()->default(0);
            $table->text('note')->nullable();
            $table->dateTime('time')->nullable();
            $table->integer('status')->default(0);
            $table->integer('deleted')->default(0);
            $table->bigInteger('created_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('approved_id')->unsigned()->nullable()->default(0);
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
        Schema::dropIfExists('transactions');
    }
}
