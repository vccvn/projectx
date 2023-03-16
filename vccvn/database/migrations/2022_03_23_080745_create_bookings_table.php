<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('owner_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('user_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('ref_id')->unsigned()->nullable()->default(0);
            $table->string('ref')->nullable();
            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->integer('quantity')->unsigned()->nullable()->default(1);
            $table->text('address')->nullable();
            $table->text('message')->nullable();
            $table->dateTime('booking_time')->nullable();
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
        Schema::dropIfExists('bookings');
    }
}
