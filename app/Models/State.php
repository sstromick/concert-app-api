<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class State extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['tags', 'notes'];

    public function country() {
        return $this->belongsTo('App\Models\Country');
    }

    public function tags()
    {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function notes()
    {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public static function getFilteredStates() {
        return QueryBuilder::for(State::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('country_id'),
                AllowedFilter::exact('abbreviation'),
                'name',
                AllowedFilter::scope('created_between'),
                AllowedFilter::exact('tags.content'),
            ]
            )
            ->get();
    }

    public function scopeCreatedBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }
}
