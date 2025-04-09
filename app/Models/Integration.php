<?php

namespace App\Models;

use App\Helpers\ModelHelper;
use App\Helpers\ModelHelperConfig;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Integration extends Model
{
    use HasFactory, ModelHelper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'preview',
        'preview_2',
        'bg_color',
        'short_description',
        'long_description',
        'is_featured',
        'is_active',
        'meta',
        'slug',
    ];

    public function modelHelperConfig(): modelHelperConfig
    {
        return ModelHelperConfig::create()->generateSlug('title')->files(['preview','preview_2']);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'json',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    /**
     * Scope a query to only include Active
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
