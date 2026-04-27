<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;
    protected $fillable = [
        'balance',
        'trader_id',
    ];

    // Relationships
    public function trader()
    {
        return $this->belongsTo(Trader::class);
    }
}
