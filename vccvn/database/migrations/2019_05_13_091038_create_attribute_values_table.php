<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('attribute_id')->unsigned();
            $table->bigInteger('int_value')->nullable()->default(0);
            $table->decimal('decimal_value', 12, 2)->nullable()->default(0);
            $table->string('varchar_value')->nullable();
            $table->text('text_value')->nullable();
            $table->string('advance_value')->nullable();

            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
            // $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_values');
    }
}
