<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('subscriptions', 'account_id')) {
                $table->bigInteger('account_id')->unsigned()->nullable();
                $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            }
            if (!Schema::hasColumn('subscriptions', 'subscription_type_id')) {
                $table->bigInteger('subscription_type_id')->unsigned()->nullable();
                $table->foreign('subscription_type_id')->references('id')->on('subscription_types')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            //
            $table->dropForeign('subscription_type_id');
            $table->dropColumn('subscription_type_id');
            $table->dropForeign('account_id');
            $table->dropColumn('account_id');
        });
    }
}
