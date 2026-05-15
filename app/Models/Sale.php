<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Sale extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'total_price',
        'customer_name',
        'customer_phone',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}