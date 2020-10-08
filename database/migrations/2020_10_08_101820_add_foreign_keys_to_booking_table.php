<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->foreign('bengkel_id', 'bengkelbook_id_fk')->references('bengkel_id')->on('bengkel')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('motorcycle_id', 'motorcycle_id_fk')->references('motorcycle_id')->on('motorcycle')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('pickup_id', 'pickup_id_fk')->references('pickup_id')->on('pickup')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('user_id', 'user_id_fk')->references('user_id')->on('user')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking', function (Blueprint $table) {
            $table->dropForeign('bengkelbook_id_fk');
            $table->dropForeign('motorcycle_id_fk');
            $table->dropForeign('pickup_id_fk');
            $table->dropForeign('user_id_fk');
        });
    }
}
