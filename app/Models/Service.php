<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $primaryKey ="service_id";
    use HasFactory;

    public function bookingDetail(){
        return $this->hasMany('App\Models\BookingDetail', 'service_id', 'service_id');
    }

    public function bengkel(){
        return $this->belongsTo('App\Models\Bengkel', 'bengkel_id', 'bengkel_id');
    }
}
