<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'category_id'
    ];

    // Relationships
    public function stores()
    {
        return $this->belongsToMany(
            Store::class,
            'sub_categories_stores',
            'sub_category_id',
            'store_id'
        );
    }

    // (اختياري لكن منطقي مع الهيكلية الجديدة)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
