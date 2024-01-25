<?php

namespace App\Models;

use App\Models\ProductOrder;
use App\Models\OrderRating;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'contactNumber',
        'totalAmount',
        'status',
        'is_delivered',
        'user_id'
    ];

    public function productOrders() {
        return $this->hasMany(ProductOrder::class);
    }

    public function user(): BelongsTo {
        return $this->BelongsTo(User::class, 'user_id', 'id');
    }

    public function rating(): HasOne
    {
        return $this->hasOne(OrderRating::class, 'order_id');
    }

}
