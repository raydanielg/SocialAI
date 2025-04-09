<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $appends = ['price_format'];
    protected $guarded = [];
    protected $casts = [
        'data' => 'array'
    ];

    public function getPriceFormatAttribute()
    {
        return amount_format($this->price);
    }
    public function activeuser()
    {
        return $this->hasMany('App\Models\User');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
