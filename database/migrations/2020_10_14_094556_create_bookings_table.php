<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->integer('booking_id', true);
            $table->integer('bengkel_id')->index('bengkelbook_id_fk');
            $table->integer('user_id')->index('user_id_fk');
            $table->integer('motorcycle_id')->index('motorcycle_id_fk');
            $table->integer('pickup_id')->nullable()->index('pickup_id_fk');
            $table->date('repairment_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('status')->default('upcoming');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
