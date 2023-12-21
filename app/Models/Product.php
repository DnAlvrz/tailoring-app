<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'productId',
        'description',
        'quantity',
        'category',
        'price',
        'images'
    ];

    protected $casts = [
        'images' => 'array'
    ];

}
