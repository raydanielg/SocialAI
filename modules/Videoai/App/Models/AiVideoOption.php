<?php

namespace Modules\Videoai\App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AiVideoOption extends Model
{
    use HasFactory, UUID;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];

    protected $casts = [
        'meta' => 'array',
    ];
}
