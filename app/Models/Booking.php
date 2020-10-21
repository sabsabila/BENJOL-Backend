<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model{
    protected $primaryKey = "booking_id";
    protected $hidden = ["updated_at", "created_at"];
    public $timestamps = false;
    use HasFactory;

    public function Service() {
        return $this->hasMany('App\Models\Service');
    }

    public function BookingDetail() {
        return $this->hasMany('App\Models\BookingDetail');
    }

    public function Motorcycle() {
        return $this->belongsTo('App\Models\Motorcycle');
    }

    public function Bengkel() {
        return $this->belongsTo('App\Models\Bengkel');
    }

    public function Payment() {
        return $this->belongsTo('App\Models\Payment');
    }

    public function Pickup() {
        return $this->belongsTo('App\Models\Pickup');
    }
}
