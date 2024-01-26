<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class ProductOrder extends Model
{
    use HasFactory;
    protected $table = 'product_order';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'name',
        'total',
        'image',
    ];

    public function order(): BelongsTo
    {
        return $this->BelongsTo(Order::class, 'order_id');
    }


}
