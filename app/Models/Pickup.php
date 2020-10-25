<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pickup extends Model
{
    protected $primaryKey='pickup_id';
    use HasFactory;

    public function booking(){
        return $this->belongsTo('App\Models\Booking');
    }
}
