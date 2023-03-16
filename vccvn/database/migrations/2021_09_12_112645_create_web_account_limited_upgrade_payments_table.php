<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebAccountLimitedUpgradePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *ALTER TABLE `web_account_limited_upgrade_payments` CHANGE `type` ` payment_method_id` BIGINT NULL DEFAULT '0';
     * @return void
     */
    public function up()
    {
        Schema::create('web_account_limited_upgrade_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('branch_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('package_id')->unsigned()->nullable()->default(0);
            $table->bigInteger('payment_method_id')->unsigned()->nullable()->default(0);
            $table->integer('account_total')->unsigned()->default(1);
            $table->double('amount', 12, 2);
            $table->string('code')->nullable();
            $table->string('note')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('web_account_limited_upgrade_payments');
    }
}
