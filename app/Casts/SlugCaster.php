<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Str;

class SlugCaster implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return $value;
    }

    public function set($model, string $key, $value, array $attributes)
    {
        $sourceAttribute = $model->getSlugSourceAttribute();
        $slug = $this->generateUniqueSlug($value ?? $attributes[$sourceAttribute], $model->id, $sourceAttribute);

        // Ensure 'slug' is set
        $model->attributes['slug'] = $slug;

        return $slug;
    }

    protected function generateUniqueSlug($value, $currentId = null, $sourceAttribute)
    {
        $slug = Str::slug($value);
        $originalSlug = $slug;
        $count = 1;

        // Check if the slug already exists in the database
        while ($this->slugExists($slug, $currentId, $sourceAttribute)) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }


        return $slug;
    }

    // Check if the slug already exists in the database
    protected function slugExists($slug, $currentId, $sourceAttribute)
    {
        $modelClass = get_class(app($this->getModelClassFromKeyName($currentId)));
        return $modelClass::where($sourceAttribute, $slug)
            ->where('id', '!=', $currentId)
            ->exists();
    }

    protected function getModelClassFromKeyName($key)
    {
        $model = config('eloquent.model_resolver')();

        if ($key) {
            return $model;
        }

        return null;
    }
}
