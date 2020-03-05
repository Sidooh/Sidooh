<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAirtimeResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airtime_responses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('phoneNumber');
            $table->string('errorMessage');
            $table->string('amount');
            $table->string('status')->default('Sent');
            $table->boolean('requestID')->index();
            $table->string('discount');
            $table->bigInteger('airtime_request_id')->unsigned();

            $table->foreign('airtime_request_id')
                ->references('id')
                ->on('airtime_requests')->onDelete('cascade')->onUpdate('cascade');

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
        Schema::dropIfExists('airtime_responses');
    }
}
