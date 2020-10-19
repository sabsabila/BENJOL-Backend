<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorcycle extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'motorcycle_id';

    use HasFactory;

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function booking() {
        return $this->hasMany('App\Models\Booking', 'bengkel_id');
    }
}
