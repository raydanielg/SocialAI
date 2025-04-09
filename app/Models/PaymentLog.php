<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'gateway_id',
        'order_id',
        'order_uuid',
        'price_currency',
        'price_amount',
        'pay_currency',
        'pay_amount',
        'receive_currency',
        'receive_amount',
        'conversion_rate',
        'payment_status',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function cardOrder(): BelongsTo
    {
        return $this->belongsTo(CardOrder::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function gateway(): BelongsTo
    {
        return $this->belongsTo(Gateway::class);
    }
}
