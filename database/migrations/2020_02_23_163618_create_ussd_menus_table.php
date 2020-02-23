<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUssdMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ussd_menus', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->integer('type')->default(1);
            $table->integer('is_parent')->default(0);
            $table->string('confirmation_message');

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
        Schema::dropIfExists('ussd_menus');
    }
}
