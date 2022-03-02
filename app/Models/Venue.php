<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Venue extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['contacts','notes', 'state'];

    public function contacts() {
        return $this->morphMany('App\Models\Contact', 'contactable');
    }

    public function events() {
        return $this->hasMany('App\Models\Event');
    }

    public function shifts() {
        return $this->hasMany('App\Models\Shift');
    }

    public function states() {
        return $this->hasMany('App\Models\State');
    }

    public function countries() {
        return $this->hasMany('App\Models\Country');
    }

    public function state() {
        return $this->belongsTo('App\Models\State');
    }

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

    public static function getFilteredVenues($returnAll = false) {
        if ($returnAll)
            return QueryBuilder::for(Venue::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('state_id'),
                    AllowedFilter::exact('country_id'),
                    AllowedFilter::exact('city'),
                    AllowedFilter::exact('postal_code'),
                    AllowedFilter::exact('phone'),
                    AllowedFilter::exact('capacity'),
                    AllowedFilter::exact('compost'),
                    AllowedFilter::exact('recycling_foh'),
                    AllowedFilter::exact('recycling_single_stream_foh'),
                    AllowedFilter::exact('recycling_sorted_foh'),
                    AllowedFilter::exact('recycling_boh'),
                    AllowedFilter::exact('recycling_single_stream_boh'),
                    AllowedFilter::exact('recycling_sorted_boh'),
                    AllowedFilter::exact('water_station'),
                    AllowedFilter::exact('village_location'),
                    AllowedFilter::exact('water_source'),
                    AllowedFilter::exact('time_zone'),
                    'name',
                    'address_1',
                    'address_2',
                    'country_text',
                    'state_text',
                    'website',
                    AllowedFilter::exact('tags.content'),
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::scope('performer')
                ])
                ->defaultSort('name')
                ->allowedSorts('name')
                ->get();
        else
            return QueryBuilder::for(Venue::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('state_id'),
                    AllowedFilter::exact('country_id'),
                    AllowedFilter::exact('city'),
                    AllowedFilter::exact('postal_code'),
                    AllowedFilter::exact('phone'),
                    AllowedFilter::exact('capacity'),
                    AllowedFilter::exact('compost'),
                    AllowedFilter::exact('recycling_foh'),
                    AllowedFilter::exact('recycling_single_stream_foh'),
                    AllowedFilter::exact('recycling_sorted_foh'),
                    AllowedFilter::exact('recycling_boh'),
                    AllowedFilter::exact('recycling_single_stream_boh'),
                    AllowedFilter::exact('recycling_sorted_boh'),
                    AllowedFilter::exact('water_station'),
                    AllowedFilter::exact('village_location'),
                    AllowedFilter::exact('water_source'),
                    AllowedFilter::exact('time_zone'),
                    'name',
                    'address_1',
                    'address_2',
                    'country_text',
                    'state_text',
                    'website',
                    AllowedFilter::exact('tags.content'),
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::scope('performer')
                ])
                ->defaultSort('name')
                ->allowedSorts('name')
                ->paginate(20);
    }

    public function scopeCreatedBetween(Builder $query, $from, $to): Builder {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }

    public function scopePerformer(Builder $query, $artist_id): Builder {
        $query->whereHas('events', function($query) use ($artist_id) {
            $query->where('artist_id', $artist_id);
        });
        $query->orWhereHas('shifts', function($query) use ($artist_id) {
            $query->where('artist_id', $artist_id);
        });

        return $query;
    }
}
