<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('payable_id');
            $table->string("payable_type");
            $table->float('amount');
            $table->string('status', 10); // pending or complete
            $table->string('type', 15); // ['mobile', 'sidooh', 'bank', 'paypal', 'other'] payment methods?
            $table->string('subtype', 15); // 'stk', 'c2b', 'cba', 'wallet', 'bonus'
            $table->bigInteger('payment_id');

            $table->timestamp("start_date")->default(Carbon::now());

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
        Schema::dropIfExists('payments');
    }
}
