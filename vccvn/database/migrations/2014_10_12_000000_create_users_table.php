<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('owner_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('master_id')->unsigned()->nullable()->default(0);
            $table->string('secret_id')->nullable();
            $table->string('secret_key')->nullable();
            $table->string('client_key')->nullable();
            $table->string('name');
            $table->string('email');//->unique();
            $table->string('username');//->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->text('google2fa_secret')->nullable();
            $table->rememberToken();
            $table->string('type')->nullable()->default('user');
            $table->string('avatar')->nullable();
            $table->integer('status')->default(1);
            $table->integer('deleted')->default(0);
            $table->timestamps();
            
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
        Schema::dropIfExists('users');
    }
}
