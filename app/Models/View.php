<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class View extends Model
{
    use HasFactory;

    protected $fillable = [
        'viewable_type',
        'viewable_id',
        'user_id',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the viewable model (advertisement, store, or post)
     */
    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who viewed (if logged in)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
