<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $hidden = ['created_at', 'updated_at'];

    protected $primaryKey = 'user_id';

    public function account()
    {
        return $this->belongsTo('App\Models\Account', 'account_id', 'id');
    }

    public function motorcycle()
    {
        return $this->hasMany('App\Models\Motorcycle', 'user_id', 'user_id');
    }
}
