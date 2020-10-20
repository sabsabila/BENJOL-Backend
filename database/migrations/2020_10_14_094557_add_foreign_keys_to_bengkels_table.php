<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBengkelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bengkels', function (Blueprint $table) {
            $table->foreign('account_id', 'bengkel_account_id_fk')->references('account_id')->on('accounts')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bengkels', function (Blueprint $table) {
            $table->dropForeign('bengkel_account_id_fk');
        });
    }
}
