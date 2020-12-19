<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'users';
    
    public $timestamps = false;

    protected $hidden = ['created_at', 'updated_at'];

    protected $primaryKey = 'user_id';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'account_id', 'id');
    }

    public function motorcycle()
    {
        return $this->hasMany('App\Models\Motorcycle', 'user_id', 'user_id');
    }

    public function booking()
    {
        return $this->hasMany('App\Models\Booking', 'user_id', 'user_id');
    }
}
