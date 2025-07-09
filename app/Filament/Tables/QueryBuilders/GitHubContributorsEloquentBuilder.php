<?php

namespace App\Filament\Tables\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class GitHubContributorsEloquentBuilder extends Builder
{
    protected Collection $collection;

    public function __construct(\Illuminate\Database\Query\Builder $query)
    {
        parent::__construct($query);
    }

    public static function fromCollection(Collection $collection)
    {
        $instance = new static(new \Illuminate\Database\Query\Builder(app('db')->connection()));
        $instance->collection = $collection;
        return $instance;
    }

    public function get($columns = ['*'])
    {
        return $this->collection->map(function ($item) {
            return (object) $item; // Convert to object for consistent access
        });
    }

    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null, $total = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage($pageName) ?: 1);
        $perPage = $perPage ?: 15;

        return new LengthAwarePaginator(
            $this->collection->forPage($page, $perPage)->values(),
            $this->collection->count(),
            $perPage,
            $page,
            [
                'path' => Paginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }

    public function count($columns = '*')
    {
        return $this->collection->count();
    }

    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        // Implement basic filtering if needed
        return $this;
    }

    public function orderBy($column, $direction = 'asc')
    {
        // Implement basic sorting if needed
        return $this;
    }

    public function clone()
    {
        $cloned = new static(new \Illuminate\Database\Query\Builder(app('db')->connection()));
        $cloned->collection = \Illuminate\Support\Collection::make($this->collection->all());
        return $cloned;
    }
}
