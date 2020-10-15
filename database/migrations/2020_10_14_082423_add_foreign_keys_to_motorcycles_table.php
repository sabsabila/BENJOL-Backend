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
            $table->foreign('user_id', 'usermotor_fk_id')->references('user_id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
            $table->dropForeign('usermotor_fk_id');
        });
    }
}
