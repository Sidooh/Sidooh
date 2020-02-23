<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUssdMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ussd_menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('menu_id')->unsigned();
            $table->foreign('menu_id')
                ->references('id')
                ->on('ussd_menus')
                ->onDelete('cascade');
            $table->string('description');
            $table->integer('type')->default(0);
            $table->bigInteger('next_menu_id')->default(NULL);
            $table->integer('step');
            $table->string('confirmation_phrase');

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
        Schema::dropIfExists('ussd_menu_items');
    }
}
