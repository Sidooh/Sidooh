<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectiveInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collective_investments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->decimal('amount', $total = 10, $places = 4);
            $table->decimal('interest_rate')->nullable();
            $table->decimal('interest', $total = 10, $places = 4)->nullable();
            $table->timestamp('investment_date')->useCurrent();
            $table->timestamp('maturity_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collective_investments');
    }
}
