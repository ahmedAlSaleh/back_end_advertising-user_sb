<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RechargeCode extends Model
{
    use HasFactory;

    protected $table = "recharge_codes";
    protected $fillable = [
        'code',
        'price',
        'is_used',
        'point_number'
    ];
}

