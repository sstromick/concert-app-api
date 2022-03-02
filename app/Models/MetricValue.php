<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class MetricValue extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['metric'];

    public function metric() {
        return $this->belongsTo('App\Models\Metric');
    }

    public function metricable(){
        return $this->morphTo();
    }

    public function metrics() {
        return $this->morphMany('App\Models\MetricValue', 'metricable');
    }

    public static function getFilteredMetricValues($returnAll = false) {
        if ($returnAll)
            return QueryBuilder::for(MetricValue::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('metric_id'),
                    AllowedFilter::exact('metricable_id'),
                    AllowedFilter::exact('metricable_type'),
                    'value',
                ])
                ->get();
        else
            return QueryBuilder::for(MetricValue::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('metric_id'),
                    AllowedFilter::exact('metricable_id'),
                    AllowedFilter::exact('metricable_type'),
                    'value',
                ])
                ->paginate(20);
    }

    public function scopeMetricableType(Builder $query, $type): Builder {
        $fullType = "App\\Models\\" . $type;
        return $query->where('metricable_type', "=",  $fullType);
    }

}
