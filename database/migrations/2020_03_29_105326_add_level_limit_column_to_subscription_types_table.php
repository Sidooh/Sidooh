<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLevelLimitColumnToSubscriptionTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscription_types', function (Blueprint $table) {
            //
            $table->integer('level_limit')->default(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscription_types', function (Blueprint $table) {
            //
            $table->dropColumn('level_limit');
        });
    }
}
