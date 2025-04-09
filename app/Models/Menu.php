<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $appends = ['created_at_diff'];
    
    protected $casts = [
        'data' => 'array',
    ];

    public function getCreatedAtDiffAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
