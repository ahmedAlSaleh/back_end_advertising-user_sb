<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubCategoriesStore extends Model
{
    use HasFactory;

    protected $table = 'sub_categories_stores';

    protected $fillable = [
        'sub_category_id',
        'store_id',
    ];

    /**
     * Get the sub category that owns the pivot.
     */
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Get the store that owns the pivot.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
