<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableOrdersAddCouponCode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->bigInteger('promo_id')->unsigned()->nullable()->after('customer_id');
            $table->string('coupon')->nullable()->after('total_money');
            $table->integer('promo_type')->unsigned()->nullable()->default(0)->after('coupon');
            $table->decimal('promo_total', 14, 2)->default(0)->after('sub_total');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->dropColumn('promo_id');
            $table->dropColumn('coupon');
            $table->dropColumn('promo_total');
            $table->dropColumn('promo_type');
        });
    }
}
