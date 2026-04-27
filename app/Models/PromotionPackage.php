<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PromotionPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'duration_days',
        'price_points',
        'benefits',
        'is_active',
    ];

    protected $casts = [
        'benefits' => 'array',
        'price_points' => 'decimal:2',
        'is_active' => 'boolean',
        'duration_days' => 'integer',
    ];

    /**
     * Get all promotions using this package
     */
    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class, 'package_id');
    }
}
