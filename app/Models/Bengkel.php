<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bengkel extends Model
{
    protected $primaryKey = 'bengkel_id';

    use HasFactory;

    public function account() {
        return $this->belongsTo('App\Models\Account', "acount_id");
    }

    public function booking() {
        return $this->hasMany('App\Models\Booking');
    }

    public function sparepart() {
        return $this->hasMany('App\Models\Sparepart');
    }
}
