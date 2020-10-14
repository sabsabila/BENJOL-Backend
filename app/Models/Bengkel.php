<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bengkel extends Model
{
    //protected $primaryKey = 'bengkel_id';
    public $timestamps = false;
    protected $hidden = ['created_at', 'updated_at']; 

    use HasFactory;
}
