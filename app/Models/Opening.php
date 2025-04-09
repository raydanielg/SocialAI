<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Opening extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'slug',
        'description',
        'short_description',
        'type',
        'category_id',
        'salary_type',
        'salary_range',
        'experience',
        'expertise',
        'featured_expire_at',
        'attachment',
        'address',
        'status',
        'apply_type',
        'meta',
        'fields',
        'expired_at',
        'live_expire_at',
        'currency',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'fields' => 'json',
      
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['is_bookmarked', 'is_expired'];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    const JOB_TYPES = [
        'Full Time',
        'Part Time',
        'Hourly-Contract',
        'Fixed-Price',
    ];

    // accessor
    public function getIsBookmarkedAttribute($value): bool
    {
        if (auth()->check()) {
            /**
             * @var \App\Models\User
             */
            $user = auth()->user();
            return (bool) $user->jobBookmarks->where('id', $this->id)->count();
        }
        return false;
    }

    public function getCreatedAtDateAttribute()
    {
        return $this->created_at?->format('d F Y');
    }

    public function getIsExpiredAttribute($value): bool
    {
        $expired_at = $this->expired_at;

        if (!$expired_at) {
            return true;
        }

        return Carbon::make($this->expired_at) < now();
    }

    
    // scopes
    public function scopeActive($query): Builder
    {
        return $query
            ->where('status', 1);
    }

    public function scopeInActive($query): Builder
    {
        return $query
            ->where('status', '!=', 1)
            ->where('expired_at', '>', today());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function service()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_opening', 'opening_id', 'category_id')
            ->where('type', 'job_category');
    }
    public function tags()
    {
        return $this->belongsToMany(Category::class, 'category_opening', 'opening_id', 'category_id')
            ->where('type', 'job_tag');
    }

    public function country()
    {
        return $this->belongsToMany(Location::class, 'location_opening', 'opening_id', 'country_id')
            ->whereNull('location_id');
    }

    public function state()
    {
        return $this->belongsToMany(Location::class, 'location_opening', 'opening_id', 'state_id')
            ->whereNotNull('location_id');
    }
    public function visits()
    {
        return $this->hasMany(Visitor::class);
    }

    public function appliedApplicants()
    {
        return $this->belongsToMany(User::class, 'userjobs', 'opening_id', 'user_id')->withPivot(['meta', 'is_hired', 'seen_at']);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(CompanyReview::class, 'job_id');
    }
}
