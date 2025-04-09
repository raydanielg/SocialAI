<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasStatusFilter
{

    /**
     * Scope a query to only include if status is active
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include if status is inactive
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive(Builder $query)
    {
        return $query->where('status', 'inactive');
    }
}
