<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('earnings', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('earnings', 'account_id')) {
                $table->bigInteger('account_id')->unsigned()->nullable();
                $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            }
            if (!Schema::hasColumn('earnings', 'transaction_id')) {
                $table->bigInteger('transaction_id')->unsigned()->nullable();
                $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('set null');
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
        Schema::table('earnings', function (Blueprint $table) {
            //
            $table->dropForeign('transaction_id');
            $table->dropColumn('transaction_id');
            $table->dropForeign('account_id');
            $table->dropColumn('account_id');
        });
    }
}
