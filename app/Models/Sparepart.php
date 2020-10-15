<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sparepart extends Model
{
    use HasFactory;

    protected $primaryKey = 'sparepart_id';
    protected $hidden = ['created_at', 'updated_at'];
}
