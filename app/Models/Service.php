<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey ="service_id";
    use HasFactory;

    function getBookingDetail(){
        return $this->hasMany('App\Models\BookingDetail');
    }
}
