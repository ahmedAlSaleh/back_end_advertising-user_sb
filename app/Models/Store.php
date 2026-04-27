<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_name',
        'store_owner_name',
        'store_number',
        'image',
        'category_id',
    ];

    // Relationships
    public function traders()
    {
        return $this->hasMany(Trader::class);
    }

    public function subCategories()
    {
        return $this->belongsToMany(
            SubCategory::class,      // الموديل المرتبط
            'sub_categories_stores', // اسم جدول الـ pivot
            'store_id',              // اسم عمود المتجر في pivot
            'sub_category_id'        // اسم عمود السبكاتيجوري في pivot
        );
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function hours()
    {
        return $this->hasMany(StoreHours::class);
    }
}
