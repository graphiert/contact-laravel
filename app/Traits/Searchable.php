<?php

namespace App\Traits;

use Illuminate\Contracts\Database\Query\Builder;

trait Searchable
{
    public function scopeSearch(Builder $query, string|null $keyword, array $columns)
    {
        $query->when(
            $keyword ?? false,
            function($query, $keyword) use ($columns) {
                foreach($columns as $i => $el) {
                    if($i == 0) {
                        if (str_contains($el, '.')) {
                            $relations = explode('.', $el);
                            $query->whereRelation($relations[0], $relations[1], 'like', '%'. $keyword .'%');
                        } else {
                            $query->where($el, 'like', '%'. $keyword .'%');
                        }
                    } else {
                        if (str_contains($el, '.')) {
                            $relations = explode('.', $el);
                            $query->orWhereRelation($relations[0], $relations[1], 'like', '%'. $keyword .'%');
                        } else {
                            $query->orWhere($el, 'like', '%'. $keyword .'%');
                        }
                    }
                }
            }
        );
    }
}
