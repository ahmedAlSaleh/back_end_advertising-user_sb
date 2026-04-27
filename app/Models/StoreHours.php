<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreHours extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'day',
        'opens_at',
        'closes_at',
        'is_closed',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
    ];

    /**
     * Get the store that owns the hours
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get day names mapping
     */
    public static function getDayNames(): array
    {
        return [
            'Sunday' => 'Sunday',
            'Monday' => 'Monday',
            'Tuesday' => 'Tuesday',
            'Wednesday' => 'Wednesday',
            'Thursday' => 'Thursday',
            'Friday' => 'Friday',
            'Saturday' => 'Saturday',
        ];
    }
}
