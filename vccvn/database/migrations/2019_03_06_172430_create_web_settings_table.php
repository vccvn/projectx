<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('web_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->nullable()->default(0);
            $table->string('base_domain')->nullable();
            $table->string('domain')->nullable();
            $table->string('subdomain')->nullable();
            $table->string('alias_domain')->nullable();
            $table->boolean('ssl')->default(false);
            $table->string('web_type')->nullable()->default('web');
            
            $table->integer('account_limited')->unsigned()->default(1);
            $table->integer('account_usage')->unsigned()->default(0);;
            
            $table->bigInteger('storage_limited')->unsigned()->default(500);
            $table->bigInteger('storage_usage')->unsigned()->default(0);

            $table->bigInteger('theme_id')->nullable()->default(0);
            $table->integer('cache_time')->unsigned()->default(0);
            $table->string('account_type')->nullable()->default('demo');
            $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists('web_settings');
    }
}
