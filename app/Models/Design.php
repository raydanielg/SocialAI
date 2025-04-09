<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Design extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'uuid',
        'title',
        'placeholder',
        'canvas',
        'status'
    ];

    protected $casts = [
        'canvas' => 'json',
    ];
}
