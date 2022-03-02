<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Volunteer extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['tags', 'notes', 'state'];

    public function VolunteerShifts() {
        return $this->hasMany('App\Models\VolunteerShift', 'volunteer_id')->setEagerLoads([]);
    }

    public function state() {
        return $this->belongsTo('App\Models\State');
    }

    public function country() {
        return $this->belongsTo('App\Models\Country');
    }

    public function tags() {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function notes() {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public function emails() {
        return $this->hasManyThrough('App\Models\Email', 'App\Models\VolunteerShift');
    }


    public static function getFilteredVolunteers($returnAll = false) {
        if ($returnAll)
            return QueryBuilder::for(Volunteer::class)
                ->allowedFilters([
                    AllowedFilter::exact('id', 'volunteers.id', false),
                    AllowedFilter::exact('state_id'),
                    AllowedFilter::exact('country_id'),
                    AllowedFilter::exact('city'),
                    AllowedFilter::exact('postal_code'),
                    AllowedFilter::exact('email'),
                    AllowedFilter::exact('phone'),
                    AllowedFilter::exact('gender'),
                    AllowedFilter::exact('tshirt_size'),
                    AllowedFilter::exact('blocked'),
                    AllowedFilter::exact('blocked_at'),
                    'first_name',
                    'last_name',
                    'address_line_1',
                    'address_line_2',
                    'country_text',
                    'state_text',
                    AllowedFilter::exact('pending', 'pending', false),
                    AllowedFilter::exact('tags.content'),
                    AllowedFilter::exact('tags.id'),
                    AllowedFilter::exact('VolunteerShifts.shift.event_id'),
                    AllowedFilter::exact('VolunteerShifts.shift.artist_id'),
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::scope('volunteer_shift_created_between'),
                    AllowedFilter::scope('volunteer_shift_created_before'),
                    AllowedFilter::scope('volunteer_shift_created_after')
                ])
                ->get();
        else
            return QueryBuilder::for(Volunteer::class)
                ->allowedFilters([
                    AllowedFilter::exact('id', 'volunteers.id', false),
                    AllowedFilter::exact('state_id'),
                    AllowedFilter::exact('country_id'),
                    AllowedFilter::exact('city'),
                    AllowedFilter::exact('postal_code'),
                    AllowedFilter::exact('email'),
                    AllowedFilter::exact('phone'),
                    AllowedFilter::exact('gender'),
                    AllowedFilter::exact('tshirt_size'),
                    AllowedFilter::exact('blocked'),
                    AllowedFilter::exact('blocked_at'),
                    'first_name',
                    'last_name',
                    'address_line_1',
                    'address_line_2',
                    'country_text',
                    'state_text',
                    AllowedFilter::exact('pending', 'pending', false),
                    AllowedFilter::exact('tags.content'),
                    AllowedFilter::exact('tags.id'),
                    AllowedFilter::exact('VolunteerShifts.shift.event_id'),
                    AllowedFilter::exact('VolunteerShifts.shift.artist_id'),
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::scope('volunteer_shift_created_between'),
                    AllowedFilter::scope('volunteer_shift_created_before'),
                    AllowedFilter::scope('volunteer_shift_created_after')
                ])
                ->paginate(20);
    }

    public static function getPendingVolunteers() {
        return QueryBuilder::for(Volunteer::class)
            ->join('volunteer_shifts', 'volunteer_shifts.volunteer_id', 'volunteers.id')
            ->join('shifts', 'shifts.id', 'volunteer_shifts.shift_id')
            ->leftJoin('artists', 'artists.id', 'shifts.artist_id')
            ->leftJoin('venues', 'venues.id', 'shifts.venue_id')
            ->join('events', 'events.id', 'shifts.event_id')
            ->select(
            'volunteers.id as id',
            'volunteers.first_name as first_name',
            'volunteers.last_name as last_name',
            'note as note',
            'events.name as event_name',
            'volunteers.tshirt_size as tshirt_size',
            'volunteers.phone as phone',
            'artists.name as artist_name',
            'volunteer_shifts.pending as pending',
            'venues.name as name',
            'venues.city as city',
            'venues.state_text as state_text'
            )
            ->allowedFilters([
                AllowedFilter::exact('id', 'volunteers.id', false),
                AllowedFilter::exact('pending', 'pending', false),
            ]
            )
            ->paginate(20);
    }

    public function scopeCreatedBetween(Builder $query, $from, $to): Builder {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }

    public function scopeVolunteerShiftCreatedAfter(Builder $query, $date): Builder {
        return $query->whereHas('VolunteerShifts', function($query) use ($date) {
            $query->where('created_at', '>', array(Carbon::parse($date)));
        });
    }

    public function scopeVolunteerShiftCreatedBefore(Builder $query, $date): Builder {
        return $query->whereHas('VolunteerShifts', function($query) use ($date) {
            $query->where('created_at', '<', array(Carbon::parse($date)));
        });
    }

    public function scopeVolunteerShiftCreatedBetween(Builder $query, $from, $to): Builder {
        return $query->whereHas('VolunteerShifts', function($query) use ($from, $to) {
            $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
        });
    }
}
