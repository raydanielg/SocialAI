<?php

namespace App\Models;

use App\Models\User;
use App\Traits\UUID;
use App\Models\Brand;
use App\Traits\HasFilter;
use App\Models\AiGenerate;
use App\Models\UserPlatform;
use App\Models\CreditHistory;
use App\Models\BrandPostPlatform;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BrandPost extends Model
{
    use HasFactory, UUID, HasFilter;

    protected $fillable = [
        "uuid",
        "brand_id",
        "user_id",
        "input",
        "title",
        "slogan",
        "status",
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['created_at_diff', 'media'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];




    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Get the
     *
     * @param  string  $value
     * @return string
     */
    public function getCreatedAtDiffAttribute($value)
    {
        return now()->make($this->attributes['created_at'])->diffForHumans([
            'short' => true
        ]);
    }

    public function media(): Attribute
    {
        return new Attribute(
            get: function () {
                $lastPublishedContent = $this->platforms()->whereNotNull('published_at')->latest()->first();
                return [
                    'type' => $lastPublishedContent?->media_type,
                    'url' => $lastPublishedContent?->media[0] ?? null,
                ];
            }
        );
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function userPlatforms(): BelongsToMany
    {
        return $this->belongsToMany(UserPlatform::class, 'platform_contents', 'brand_content_id');
    }

    public function platforms(): HasMany
    {
        return $this->hasMany(BrandPostPlatform::class);
    }
    public function generates(): MorphMany
    {
        return $this->morphMany(AiGenerate::class, 'generatable');
    }

    // accessor
    public function getPlatform($platform): BrandPostPlatform
    {
        return $this->platforms()->where('platform', $platform)->first();
    }

    public function getContentFor($platform)
    {
        return $this->getPlatform($platform)?->content ?? '';
    }

    public function credit_histories(): MorphMany
    {
        return $this->morphMany(CreditHistory::class, 'creditable');
    }
}
