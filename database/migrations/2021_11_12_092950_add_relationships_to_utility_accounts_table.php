<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToUtilityAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('utility_accounts', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('utility_accounts', 'account_id')) {
                $table->bigInteger('account_id')->unsigned();
                $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

                $table->index(['account_id', 'provider']);
                $table->unique(['account_id', 'provider', 'utility_number']);
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
        Schema::table('utility_accounts', function (Blueprint $table) {
            //
        });
    }
}
