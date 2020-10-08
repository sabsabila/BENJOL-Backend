<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSparepartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sparepart', function (Blueprint $table) {
            $table->foreign('bengkel_id', 'bengkel_id_fk')->references('bengkel_id')->on('bengkel')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sparepart', function (Blueprint $table) {
            $table->dropForeign('bengkel_id_fk');
        });
    }
}
