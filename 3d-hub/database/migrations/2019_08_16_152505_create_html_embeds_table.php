<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHtmlEmbedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('html_embeds', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('area_id')->unsigned();
            $table->string('label')->nullable();
            $table->string('slug')->nullable();
            $table->text('code')->nullable();
            $table->integer('priority')->unsigned()->default(0);
            $table->boolean('status')->nullable()->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('html_embeds');
    }
}
