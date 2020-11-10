<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bengkel extends Model
{
    protected $primaryKey = 'bengkel_id';

    public $timestamps = false;

    protected $hidden = ['created_at', 'updated_at'];
    
    use HasFactory;

    public function account()
    {
        return $this->belongsTo('App\Models\Account', 'account_id', 'id');
    }

    public function sparepart()
    {
        return $this->hasMany('App\Models\Sparepart', 'bengkel_id', 'bengkel_id');
    }

    public function service(){
        return $this->hasMany('App\Models\Service', 'bengkel_id', 'bengkel_id');
    }

    public function booking()
    {
        return $this->hasMany('App\Models\Booking', 'bengkel_id', 'bengkel_id');
    }
}
