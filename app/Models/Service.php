<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Service extends Model
{
    protected $primaryKey ="service_id";
    use HasFactory;

    // public function booking(){
    //     return $this->belongsTo('App\Models\Booking');
    // }

    public function getBookingDetail(){
        return $this->hasMany('App\Models\BookingDetail');
    }
}
