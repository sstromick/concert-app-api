<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class NonProfitShift extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['NonProfit', 'tags', 'notes'];

    public function shift() {
        return $this->belongsTo('App\Models\Shift');
    }

    public function NonProfit() {
        return $this->belongsTo('App\Models\NonProfit')->setEagerLoads([]);
    }

    public function tags()
    {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function notes()
    {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public static function getFilteredNonProfitShifts() {
        return QueryBuilder::for(NonProfitShift::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('shift_id'),
                AllowedFilter::exact('non_profit_id'),
                AllowedFilter::exact('phone'),
                AllowedFilter::exact('item_actions'),
                AllowedFilter::exact('tags.content'),
                'contact_name',
                'email',
                'emai',
                'item',
                AllowedFilter::scope('created_between'),
            ]
            )
            ->get();
    }

    public function scopeCreatedBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }
}
