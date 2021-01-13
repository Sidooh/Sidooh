<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToSubInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_investments', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('sub_investments', 'account_id')) {
                $table->bigInteger('account_id')->unsigned();
                $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            }
            if (!Schema::hasColumn('sub_investments', 'collective_investment_id')) {
                $table->bigInteger('collective_investment_id')->unsigned();
                $table->foreign('collective_investment_id')->references('id')->on('collective_investments')->onDelete('cascade');
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
        Schema::table('sub_investments', function (Blueprint $table) {
            //
        });
    }
}
