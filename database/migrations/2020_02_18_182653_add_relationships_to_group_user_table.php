<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipsToGroupUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_user', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('group_user', 'group_id')) {
                $table->integer('group_id')->unsigned()->nullable();
                $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
            }
            if (!Schema::hasColumn('group_user', 'user_id')) {
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::table('group_user', function (Blueprint $table) {
            //
            $table->dropForeign('user_id');
            $table->dropColumn('user_id');
            $table->dropForeign('group_id');
            $table->dropColumn('group_id');
        });
    }
}
