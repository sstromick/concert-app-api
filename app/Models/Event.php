<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Log;

class Event extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['contacts', 'shifts', 'tags', 'notes'];

    public function shifts() {
        return $this->hasMany('App\Models\Shift')->setEagerLoads([])->orderBy('start_date', 'asc');
    }

    public function artist() {
        return $this->belongsTo('App\Models\Artist');
    }

    public function venue() {
        return $this->belongsTo('App\Models\Venue');
    }

    public function tags()
    {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function notes()
    {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public function contacts() {
        return $this->morphMany('App\Models\Contact', 'contactable');
    }

    public static function getFilteredEvents($returnAll = false) {
        if ($returnAll)
            return QueryBuilder::for(Event::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('artist_id'),
                    AllowedFilter::exact('venue_id'),
                    AllowedFilter::exact('passive'),
                    AllowedFilter::exact('teams'),
                    AllowedFilter::exact('contact_phone'),
                    AllowedFilter::exact('CO2_artist_tonnes'),
                    AllowedFilter::exact('CO2_fans_tonnes'),
                    AllowedFilter::exact('tags.content'),
                    AllowedFilter::partial('artist.name'),
                    AllowedFilter::partial('venue.name'),
                    'name',
                    AllowedFilter::scope('start_between'),
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::scope('ends_before'),
                    AllowedFilter::scope('active'),
                    AllowedFilter::scope('inactive'),
                    AllowedFilter::scope('contact'),
                ])
                ->defaultSort('start_date')
                ->allowedSorts('start_date')
                ->get();
        else
            return QueryBuilder::for(Event::class)
                    ->allowedFilters([
                        AllowedFilter::exact('id'),
                        AllowedFilter::exact('artist_id'),
                        AllowedFilter::exact('venue_id'),
                        AllowedFilter::exact('passive'),
                        AllowedFilter::exact('teams'),
                        AllowedFilter::exact('contact_phone'),
                        AllowedFilter::exact('CO2_artist_tonnes'),
                        AllowedFilter::exact('CO2_fans_tonnes'),
                        AllowedFilter::exact('tags.content'),
                        AllowedFilter::partial('artist.name'),
                        AllowedFilter::partial('venue.name'),
                        'name',
                        AllowedFilter::scope('start_between'),
                        AllowedFilter::scope('created_between'),
                        AllowedFilter::scope('active'),
                        AllowedFilter::scope('inactive'),
                        AllowedFilter::scope('starts_after'),
                        AllowedFilter::scope('ends_before'),
                        AllowedFilter::scope('contact'),
                    ])
                    ->defaultSort('start_date')
                    ->allowedSorts('start_date')
                    ->paginate(20);
    }

    public function scopeContact(Builder $query, $id): Builder
    {
        return $query->whereHas('contacts', function ($query) use ($id) {
                    $query->whereHasMorph('contactable', [Event::class], function ($query) use ($id) {
                            $query->where('contact_master_id', $id);
                    });
                });
    }

    public function scopeStartsAfter(Builder $query, $date): Builder
    {
        return $query->where('start_date', '>', array(Carbon::parse($date)));
    }

    public function scopeEndsBefore(Builder $query, $date): Builder
    {
        return $query->where('end_date', '<', array(Carbon::parse($date)));
    }

    public function scopeStartBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('start_date', array(Carbon::parse($from), Carbon::parse($to)));
    }

    public function scopeCreatedBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }

    public function scopeActive(Builder $query, $active): Builder
    {
        if ($active == "1" || strtoupper($active) == "Y" || strtoupper($active) == "YES")
            return $query->whereRaw('(end_date >= now())');
        else
            return $query->whereRaw('(end_date < now())');
    }

    public function scopeInactive(Builder $query, $inactive): Builder
    {
        if ($inactive == "1" || strtoupper($inactive) == "Y" || strtoupper($inactive) == "YES")
            return $query->whereRaw('(end_date < now())');
        else
            return $query->whereRaw('(end_date >= now())');
    }
}

