<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigInteger('profile_id')->unsigned();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('gender')->nullable()->default('male');
            $table->date('birthday')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            $table->bigInteger('region_id')->unsigned()->default(0);
            $table->bigInteger('district_id')->unsigned()->default(0);
            $table->bigInteger('ward_id')->unsigned()->default(0);
            $table->bigInteger('academic_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('work_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('org_id')->unsigned()->nullable()->default(0);
            $table->timestamps();
            $table->primary('profile_id');

            
            // $table->foreign('profile_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
