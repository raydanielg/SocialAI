<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{

    public function scopeFilterOn(Builder $query, array $searchableColumns = [], $searchColumn = null, $searchKeyword = null): Builder
    {
        $searchColumn ??= request('type');
        $searchKeyword ??= request('search');

        $query->when(
            in_array($searchColumn, $searchableColumns),
            fn($q) => $this->searchColumn($q, $searchColumn, $searchKeyword)
        );

        return $query;
    }

    public function scopeFilterOnRelation(Builder $query, array $searchableRelations = [], $searchColumn = null, $searchKeyword = null): Builder
    {
        $searchColumn = $searchColumn ?? request('type');
        $keyword = $searchKeyword ?? request('search');

        foreach ($searchableRelations as $relation_column) {
            $arr = str($relation_column)->explode('_')->toArray();
            $relation = $arr[0];
            $column = $arr[1];
            $query->when($searchColumn == $relation_column)
                ->whereHas($relation, fn($q) => $this->searchColumn($q, $column, $keyword));
        }

        return $query;
    }

    private function searchColumn(Builder $query, $column, $keyword = ''): Builder
    {
        $query->where($column, 'LIKE', "%$keyword%");
        return $query;
    }
}
