<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_settings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->float("g_percentage");
            $table->float('u_percentage');
            $table->float('o_percentage');
            $table->enum('status', ['inactive', 'active'])->default('pending');

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
        Schema::dropIfExists('product_settings');
    }
}
