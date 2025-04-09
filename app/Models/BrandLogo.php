<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrandLogo extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'preview', 'status', 'canvas'];

    const STATUS = ['active', 'inactive'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */


    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
