<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
    protected $primaryKey = "bookingDetail_id";
    protected $hidden = ["updated_at", "created_at"];
    public $timestamps = false;
    
    use HasFactory;

    public function Booking() {
        return $this->belongsTo('App\Models\Booking', 'booking_id', 'booking_id');
    }

    public function Service() {
        return $this->belongsTo('App\Models\Service', 'service_id', 'service_id');
    }
}
