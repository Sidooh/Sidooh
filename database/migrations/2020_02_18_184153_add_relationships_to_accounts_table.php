<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('accounts', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('accounts', 'telco_id')) {
                $table->bigInteger('telco_id')->unsigned();
                $table->foreign('telco_id')->references('id')->on('telcos')->onDelete('cascade');
            }
            if (!Schema::hasColumn('accounts', 'referrer_id')) {
                $table->bigInteger('referrer_id')->unsigned()->nullable();
                $table->foreign('referrer_id')->references('id')->on('accounts')->onDelete('set null');
            }
            if (!Schema::hasColumn('accounts', 'user_id')) {
                $table->bigInteger('user_id')->unsigned()->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('accounts', function (Blueprint $table) {
            //
            $table->dropForeign('user_id');
            $table->dropColumn('user_id');
            $table->dropForeign('referrer_id');
            $table->dropColumn('referrer_id');
            $table->dropForeign('telco_id');
            $table->dropColumn('telco_id');
        });
    }
}
