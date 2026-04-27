<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'favorite_id',
        'favorite_type',
    ];

    // Morph
    public function related()
    {
        return $this->morphTo();
    }
}
