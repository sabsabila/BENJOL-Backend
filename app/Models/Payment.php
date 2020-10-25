<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';
    use HasFactory;

    public function booking()
    {
        return $this->belongsTo('App\Models\Booking', 'booking_id', 'booking_id');
    }
}
