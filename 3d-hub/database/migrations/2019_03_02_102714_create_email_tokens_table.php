<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('type')->default('confirm');
            $table->string('ref')->nullable();
            $table->bigInteger('ref_id')->unsigned()->nullable()->default(0);
            $table->string('token');
            $table->string('code', 6)->nullable();
            $table->dateTime('expired_at');
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
        Schema::dropIfExists('email_tokens');
    }
}
