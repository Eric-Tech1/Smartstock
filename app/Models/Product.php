<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'price',
        'stock_quantity',
        'category',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function isLowStock()
{
    return $this->stock_quantity <= $this->low_stock_threshold;
}
}