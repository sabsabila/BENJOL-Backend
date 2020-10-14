<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMotorcyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->foreign('user_id', 'motorycycle_user_id_fk')->references('user_id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('motorcycles', function (Blueprint $table) {
            $table->dropForeign('motorycycle_user_id_fk');
        });
    }
}
