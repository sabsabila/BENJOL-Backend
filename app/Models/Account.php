<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Account as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use App\Models\Account;

class Account extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public function user()
    {
        return $this->hasOne('App\Models\User', 'account_id', 'id');
    }

    public function bengkel()
    {
        return $this->hasOne('App\Models\Bengkel', 'account_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
