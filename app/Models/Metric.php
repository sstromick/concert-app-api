<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Metric extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public static function getFilteredMetrics($returnAll = false) {
        if ($returnAll)
            return QueryBuilder::for(Metric::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('metric_type'),
                    'name',
                    AllowedFilter::exact('active'),
                ]
                )
                ->orderBy('name', 'asc')
                ->get();
        else
            return QueryBuilder::for(Metric::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('metric_type'),
                    'name',
                    AllowedFilter::exact('active'),
                ]
                )
                ->orderBy('name', 'asc')
                ->paginate(20);
    }

}
