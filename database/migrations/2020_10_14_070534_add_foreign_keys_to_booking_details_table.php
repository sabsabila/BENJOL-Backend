<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_details', function (Blueprint $table) {
            $table->foreign('booking_id', 'bookingdet_id_fk')->references('booking_id')->on('bookings')->onUpdate('RESTRICT')->onDelete('RESTRICT');
            $table->foreign('service_id', 'service_id_fk')->references('service_id')->on('services')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_details', function (Blueprint $table) {
            $table->dropForeign('bookingdet_id_fk');
            $table->dropForeign('service_id_fk');
        });
    }
}
