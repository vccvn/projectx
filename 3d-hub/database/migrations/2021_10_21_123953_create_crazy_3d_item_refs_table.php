<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrazy3dItemRefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crazy_3d_item_refs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id')->unsigned()->default(0);
            $table->string('ref')->nullable();
            $table->bigInteger('ref_id')->unsigned()->default(0);
            $table->json('__data__')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crazy_3d_item_refs');
    }
}
