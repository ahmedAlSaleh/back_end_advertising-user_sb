<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'notes',
        'price',
        'trader_id',
        'type',
        'is_featured',
        'featured_until',
        'feature_type',
        'scheduled_at',
        'expires_at',
        'status'
    ];

    protected $casts = [
        'featured_until' => 'datetime',
        'scheduled_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_featured' => 'boolean',
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

    public function favorite()
    {
        return $this->morphMany(Favorite::class, 'related');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
    public function rates()
    {
        // FK on Rate is rated_id, local key is id
        return $this->hasMany(Rate::class, 'rated_id', 'id')
            ->where('rated_type', 'advertisement'); // or ->where('rated_type', static::class)
    }

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    /**
     * Get status labels
     */
    public static function getStatusLabels(): array
    {
        return [
            'draft' => 'Draft',
            'scheduled' => 'Scheduled',
            'active' => 'Active',
            'expired' => 'Expired',
            'paused' => 'Paused',
        ];
    }
}
