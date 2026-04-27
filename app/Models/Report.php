<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'reporter_type',
        'reportable_id',
        'reportable_type',
        'reason',
        'description',
        'status',
        'admin_notes',
        'resolved_at',
        'resolved_by',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    /**
     * Get the reporter (user or trader)
     */
    public function reporter(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the reportable item (advertisement, store, trader, post)
     */
    public function reportable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get reason labels for translation
     */
    public static function getReasonLabels(): array
    {
        return [
            'spam' => 'Spam or Scam',
            'fraud' => 'Fraud or Deception',
            'inappropriate' => 'Inappropriate Content',
            'misleading' => 'Misleading Information',
            'offensive' => 'Offensive Content',
            'other' => 'Other',
        ];
    }

    /**
     * Get status labels
     */
    public static function getStatusLabels(): array
    {
        return [
            'pending' => 'Pending Review',
            'reviewed' => 'Under Review',
            'resolved' => 'Resolved',
            'dismissed' => 'Dismissed',
        ];
    }
}
