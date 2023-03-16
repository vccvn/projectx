<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePromosAddRef extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promos', function (Blueprint $table) {
            //
            $table->string('scope')->nullable()->default('product')->after('description');
            $table->integer('limited_total')->unsigned()->default(0)->after('code');
            $table->integer('usage_total')->unsigned()->default(0)->after('limited_total');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promos', function (Blueprint $table) {
            //
            $table->dropColumn('scope');
            $table->dropColumn('limited_total');
            $table->dropColumn('usage_total');
        });
    }
}
