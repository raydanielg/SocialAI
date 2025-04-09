<?php

namespace App\Models;

use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrandPostPlatform extends Model
{
    use HasFactory, HasFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_post_id',
        'user_platform_id',
        'platform',
        'content',
        'media_type',
        'media',
        'thumbnail',
        'post_id',
        'reactions',
        'comments',
        'scheduled_at',
        'published_at',
        'status',
        'data',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'media' => 'array',
        'data' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['requirements'];

    /**
     * Get the requirements for the specific platform based on the platform configuration.
     *
     * @return Attribute
     */
    protected function requirements(): Attribute
    {
        return Attribute::make(
            get: fn() => config("platform.{$this->platform}.requirements"),
        );
    }


    /**
     * Get the brand post that owns the BrandPostPlatform
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brandPost(): BelongsTo
    {
        return $this->belongsTo(BrandPost::class);
    }

    /**
     * The user platform that owns the BrandPostPlatform
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function userPlatform(): BelongsTo
    {
        return $this->belongsTo(UserPlatform::class, 'user_platform_id');
    }

    /**
     * Scope a query to only include scheduled items.
     *
     * @param mixed $query
     * @return mixed
     */
    public function scopeScheduled($query)
    {
        return $query->whereNotNull('scheduled_at');
    }
}
