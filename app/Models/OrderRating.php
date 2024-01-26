<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderRating extends Model
{
    use HasFactory;
    protected $table = 'order_rating';

    protected $fillable = [
        'order_id',
        'message',
        'rating'
    ];

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
