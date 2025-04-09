<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    abstract public function getSlugSourceAttribute();

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Use the dynamically determined source attribute
            $model->slug = $model->generateUniqueSlug($model->{$model->getSlugSourceAttribute()});
        });
    }

    protected function generateUniqueSlug($value)
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;
        $count = 1;

        // Check if the slug already exists in the database
        while ($this->slugExists($slug)) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    // Check if the slug already exists in the database
    protected function slugExists($slug)
    {
        return static::where('slug', $slug)->exists();
    }
}
