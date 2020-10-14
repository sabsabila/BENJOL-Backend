<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->foreign('bengkel_id', 'booking_bengkel_id_fk')->references('bengkel_id')->on('bengkels')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('motorcycle_id', 'booking_motorcycle_id_fk')->references('motorcycle_id')->on('motorcycles')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('pickup_id', 'booking_pickup_id_fk')->references('pickup_id')->on('pickups')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('user_id', 'booking_user_id_fk')->references('user_id')->on('users')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign('booking_bengkel_id_fk');
            $table->dropForeign('booking_motorcycle_id_fk');
            $table->dropForeign('booking_pickup_id_fk');
            $table->dropForeign('booking_user_id_fk');
        });
    }
}
