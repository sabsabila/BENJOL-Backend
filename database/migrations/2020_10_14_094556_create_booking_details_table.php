<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_details', function (Blueprint $table) {
            $table->integer('bookingDetail_id', true);
            $table->integer('booking_id')->index('bookingdet_id_fk');
            $table->integer('service_id')->index('service_id_fk');
            $table->string('repairment_note');            
            $table->string('bengkel_note')->nullable();
            $table->integer('service_cost')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_details');
    }
}
