<?php

namespace App\Models;

use App\Models\ProductOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'contactNumber',
        'totalAmount',
        'status',
        'is_delivered'
    ];

    public function productOrders() {
        return $this->hasMany(ProductOrder::class);
    }
}
