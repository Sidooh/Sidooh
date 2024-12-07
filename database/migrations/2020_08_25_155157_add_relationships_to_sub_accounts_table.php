<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToSubAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_accounts', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('sub_accounts', 'account_id')) {
                $table->bigInteger('account_id')->unsigned();
                $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');

                $table->unique(['account_id', 'type']);
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
        Schema::table('sub_accounts', function (Blueprint $table) {
            //
        });
    }
}
