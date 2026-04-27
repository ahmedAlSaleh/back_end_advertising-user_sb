<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'related_id',
        'related_type',
    ];

    // Morph
    public function related()
    {
        return $this->morphTo();
    }
}
