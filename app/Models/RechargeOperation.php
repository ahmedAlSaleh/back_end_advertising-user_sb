<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RechargeOperation extends Model
{
    use HasFactory;

    protected $table = "recharge_operations";
    protected $fillable = [
        'trader_id',
        'code',
        'type',
        'amount',

    ];

    public function trader()
    {
        return $this->belongsTo(Trader::class, 'trader_id');
    }
}
