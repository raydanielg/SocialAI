<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditLog extends Model
{
    use HasFactory;

    protected $fillable  = [
        'invoice_no',
        'user_id',
        'gateway_id',
        'price',
        'credits',
        'payment_id',
        'status',
        'meta'
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = CreditLog::max('id') + 1;
            $model->invoice_no = str_pad($model->id, 7, '0', STR_PAD_LEFT);
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }
}
