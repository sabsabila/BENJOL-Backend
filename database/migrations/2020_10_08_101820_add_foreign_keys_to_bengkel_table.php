<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBengkelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bengkel', function (Blueprint $table) {
            $table->foreign('account_id', 'accountbengkel_id_fk')->references('account_id')->on('account')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bengkel', function (Blueprint $table) {
            $table->dropForeign('accountbengkel_id_fk');
        });
    }
}
