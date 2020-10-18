<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public function booking()
    {
        return $this->hasMany('App\Models\Booking');
    }

    protected $primaryKey = 'payment_id';

    use HasFactory;
}
