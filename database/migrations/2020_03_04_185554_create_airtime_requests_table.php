<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirtimeRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airtime_requests', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('errorMessage');
            $table->integer('numSent');
            $table->string('totalAmount');
            $table->string('totalDiscount');

            $table->unsignedBigInteger('transaction_id')->nullable();

//            $table->foreign('CheckoutRequestID')
//                ->references('CheckoutRequestID')
//                ->on('mpesa_stk_requests')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('airtime_requests');
    }
}
