<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'advertisement_id',
        'package_id',
        'started_at',
        'expires_at',
        'points_paid',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'points_paid' => 'decimal:2',
    ];

    /**
     * Get the advertisement being promoted
     */
    public function advertisement(): BelongsTo
    {
        return $this->belongsTo(Advertisement::class);
    }

    /**
     * Get the package used for this promotion
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(PromotionPackage::class);
    }

    /**
     * Check if promotion is still active
     */
    public function isActive(): bool
    {
        return now()->lt($this->expires_at);
    }
}
