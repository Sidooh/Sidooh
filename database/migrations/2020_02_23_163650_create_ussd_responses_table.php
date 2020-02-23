<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUssdResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ussd_responses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('user_id')->unsigned();
            $table->integer('menu_id')->unsigned();
            $table->integer('menu_item_id')->unsigned();
            $table->text('response');

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
        Schema::dropIfExists('ussd_responses');
    }
}
