<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptionDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('option_datas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('group_id')->unsigned();
            $table->string('name')->default('option_name');
            $table->string('label')->default('Option Name');
            $table->string('type')->default('text'); // type of input. e.g: text, number, file, email, password. checkvox, checkbox, radio, select, [extra: crazyselect. craxy...]
            $table->string('value_type')->default('text'); // type of value. e.g string, number, boolean
            $table->text('value')->nullable();
            $table->integer('priority')->unsigned()->nullable()->default(12);
            $table->json('props')->nullable();
            $table->boolean('can_delete')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('option_datas');
    }
}
