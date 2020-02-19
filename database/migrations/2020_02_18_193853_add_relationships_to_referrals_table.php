<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referrals', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('referrals', 'account_id')) {
                $table->integer('account_id')->unsigned();
                $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            }
            if (!Schema::hasColumn('referrals', 'user_id')) {
                $table->integer('referee_id')->unsigned()->unique()->nullable();
                $table->foreign('referee_id')->references('id')->on('accounts')->onDelete('cascade');
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
        Schema::table('referrals', function (Blueprint $table) {
            //
            $table->dropForeign('referee_id');
            $table->dropColumn('referee_id');
            $table->dropForeign('account_id');
            $table->dropColumn('account_id');
        });
    }
}
