<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUssdUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ussd_users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('phone')->unique();
            $table->integer('session')->default(0);
            $table->integer('progress')->default(0);
            $table->integer('pin')->default(0);
            $table->integer('menu_id')->default(0);
            $table->integer('confirm_from')->default(0);
            $table->integer('menu_item_id')->default(0);
            $table->integer('difficulty_level')->default(0);

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
        Schema::dropIfExists('ussd_users');
    }
}
