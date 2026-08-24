<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'sku',
        'name',
        'category',
        'brand',
        'unit',
        'purchase_price',
        'selling_price',
        'current_stock',
        'minimum_stock_level',
        'image',
        'status',
        'description',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'current_stock' => 'integer',
        'minimum_stock_level' => 'integer',
    ];
}
