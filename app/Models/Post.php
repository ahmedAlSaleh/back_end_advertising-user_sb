<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'trader_id', // Foreign key for trader
    ];

    // Relationships
    public function trader()
    {
        return $this->belongsTo(Trader::class);
    }

    public function image()
    {
        return $this->morphMany(Image::class, 'related');
    }
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function likesCount()
    {
        return $this->likes()->where('like', true)->count();
    }

    public function dislikesCount()
    {
        return $this->likes()->where('dislike', true)->count();
    }

}
