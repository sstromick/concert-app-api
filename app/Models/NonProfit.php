<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class NonProfit extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['contacts', 'NonProfitShifts', 'country', 'state', 'tags', 'notes'];

    public function contacts() {
        return $this->morphMany('App\Models\Contact', 'contactable');
    }

    public function NonProfitShifts() {
        return $this->hasMany('App\Models\NonProfitShift');
    }

    public function state() {
        return $this->belongsTo('App\Models\State')->setEagerLoads([]);
    }

    public function country() {
        return $this->belongsTo('App\Models\Country')->setEagerLoads([]);
    }

    public function tags() {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function notes() {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public static function getFilteredNonProfits($returnAll = false) {
        if ($returnAll)
            return QueryBuilder::for(NonProfit::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('state_id'),
                    AllowedFilter::exact('country_id'),
                    AllowedFilter::exact('city'),
                    AllowedFilter::exact('postal_code'),
                    AllowedFilter::exact('tags.content'),
                    AllowedFilter::exact('tags.id'),
                    'name',
                    'address_line_1',
                    'address_line_2',
                    'country_text',
                    'state_text',
                    'website',
                    AllowedFilter::scope('created_between'),
                ]
                )
                ->get();
        else
            return QueryBuilder::for(NonProfit::class)
                    ->allowedFilters([
                        AllowedFilter::exact('id'),
                        AllowedFilter::exact('state_id'),
                        AllowedFilter::exact('country_id'),
                        AllowedFilter::exact('city'),
                        AllowedFilter::exact('postal_code'),
                        AllowedFilter::exact('tags.content'),
                        AllowedFilter::exact('tags.id'),
                        'name',
                        'address_line_1',
                        'address_line_2',
                        'country_text',
                        'state_text',
                        'website',
                        AllowedFilter::scope('created_between'),
                    ]
                    )
                    ->paginate(20);
    }

    public static function getFilteredNonProfitsNoPaginate() {
        return QueryBuilder::for(NonProfit::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('state_id'),
                AllowedFilter::exact('country_id'),
                AllowedFilter::exact('city'),
                AllowedFilter::exact('postal_code'),
                AllowedFilter::exact('tags.content'),
                AllowedFilter::exact('tags.id'),
                'name',
                'address_line_1',
                'address_line_2',
                'country_text',
                'state_text',
                'website',
                AllowedFilter::scope('created_between'),
            ]
            )
            ->get();
    }

    public function scopeCreatedBetween(Builder $query, $from, $to): Builder {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }
}
