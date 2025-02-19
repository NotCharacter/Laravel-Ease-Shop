<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'product_name', 'full_name', 'email', 'phone', 'address',
        'quantity', 'total_price', 'payment_method', 'status'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
