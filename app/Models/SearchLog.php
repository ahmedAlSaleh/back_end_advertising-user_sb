<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'keyword',
        'category_id',
        'sub_category_id',
        'city',
        'price_min',
        'price_max',
        'rating_min',
        'sort_by',
        'sort_order',
        'results_count',
        'user_ip',
        'user_id',
    ];

    protected $casts = [
        'price_min' => 'decimal:2',
        'price_max' => 'decimal:2',
        'rating_min' => 'decimal:2',
        'results_count' => 'integer',
    ];
}
