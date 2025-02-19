<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // use HashFactory;
    protected $fillable = ['name', 'description', 'category', 'quantity', 'price', 'images'];
    protected $casts = [
        'images' => 'array', // Automatically converts JSON to array
    ];

}
