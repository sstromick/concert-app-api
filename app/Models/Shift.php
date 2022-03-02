<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Log;

class Shift extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['ShiftSchedules', 'VolunteerShifts', 'NonProfitShifts', 'tags', 'notes'];

    public function setDoorsAttribute($value)
    {
        $this->attributes['doors'] = Carbon::parse($value)->format('H:i');
    }

    public function setCheckInAttribute($value)
    {
        $this->attributes['check_in'] = Carbon::parse($value)->format('H:i');
    }

    public function getDoorsAttribute($doors)
    {
        return date('h:i A', strtotime($doors));
    }

    public function getCheckInAttribute($checkin)
    {
        return date('h:i A', strtotime($checkin));
    }

    public function ShiftSchedules() {
        return $this->hasMany('App\Models\ShiftSchedule');
    }

    public function VolunteerShifts() {
        return $this->hasMany('App\Models\VolunteerShift', 'shift_id');
    }

    public function NonProfitShifts() {
        return $this->hasMany('App\Models\NonProfitShift');
    }

    public function event() {
        return $this->belongsTo('App\Models\Event');
    }

    public function venue() {
        return $this->belongsTo('App\Models\Venue');
    }

    public function artist() {
        return $this->belongsTo('App\Models\Artist');
    }

    public function tags()
    {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function notes()
    {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public function metrics()
    {
        return $this->morphMany('App\Models\MetricValue', 'metricable');
    }

    public static function getFilteredShifts($returnAll = false) {
        if ($returnAll)
            return QueryBuilder::for(Shift::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('event_id'),
                    AllowedFilter::exact('artist_id'),
                    AllowedFilter::exact('venue_id'),
                    'name',
                    AllowedFilter::exact('start_date'),
                    AllowedFilter::exact('end_date'),
                    AllowedFilter::exact('doors'),
                    AllowedFilter::exact('check_in'),
                    AllowedFilter::exact('hours_worked'),
                    AllowedFilter::exact('volunteer_cap'),
                    AllowedFilter::exact('item'),
                    AllowedFilter::exact('item_sold'),
                    AllowedFilter::exact('item_bof_free'),
                    AllowedFilter::exact('item_revenue_cash'),
                    AllowedFilter::exact('item_revenue_cc'),
                    AllowedFilter::exact('biod_gallons'),
                    AllowedFilter::exact('compost_gallons'),
                    AllowedFilter::exact('water_foh_gallons'),
                    AllowedFilter::exact('water_boh_gallons'),
                    AllowedFilter::exact('farms_supported'),
                    AllowedFilter::exact('tickets_sold'),
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::scope('start_between'),
                    AllowedFilter::scope('ends_before'),
                    AllowedFilter::scope('starts_after'),
                    AllowedFilter::exact('tags.content'),
                ])
                ->defaultSort('-start_date')
                ->allowedSorts('start_date')
                ->get();
        else
            return QueryBuilder::for(Shift::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('event_id'),
                    AllowedFilter::exact('artist_id'),
                    AllowedFilter::exact('venue_id'),
                    'name',
                    AllowedFilter::exact('start_date'),
                    AllowedFilter::exact('end_date'),
                    AllowedFilter::exact('doors'),
                    AllowedFilter::exact('check_in'),
                    AllowedFilter::exact('hours_worked'),
                    AllowedFilter::exact('volunteer_cap'),
                    AllowedFilter::exact('item'),
                    AllowedFilter::exact('item_sold'),
                    AllowedFilter::exact('item_bof_free'),
                    AllowedFilter::exact('item_revenue_cash'),
                    AllowedFilter::exact('item_revenue_cc'),
                    AllowedFilter::exact('biod_gallons'),
                    AllowedFilter::exact('compost_gallons'),
                    AllowedFilter::exact('water_foh_gallons'),
                    AllowedFilter::exact('water_boh_gallons'),
                    AllowedFilter::exact('farms_supported'),
                    AllowedFilter::exact('tickets_sold'),
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::scope('start_between'),
                    AllowedFilter::scope('end_between'),
                    AllowedFilter::scope('starts_after'),
                    AllowedFilter::exact('tags.content'),
                    AllowedFilter::scope('ends_before'),
                ])
                ->defaultSort('-start_date')
                ->allowedSorts('start_date')
                ->paginate(20);
    }

    public static function getFilteredShiftsAll() {
        return QueryBuilder::for(Shift::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('event_id'),
                AllowedFilter::exact('artist_id'),
                AllowedFilter::exact('venue_id'),
                'name',
                AllowedFilter::exact('start_date'),
                AllowedFilter::exact('end_date'),
                AllowedFilter::exact('doors'),
                AllowedFilter::exact('check_in'),
                AllowedFilter::exact('hours_worked'),
                AllowedFilter::exact('volunteer_cap'),
                AllowedFilter::exact('item'),
                AllowedFilter::exact('item_sold'),
                AllowedFilter::exact('item_bof_free'),
                AllowedFilter::exact('item_revenue_cash'),
                AllowedFilter::exact('item_revenue_cc'),
                AllowedFilter::exact('biod_gallons'),
                AllowedFilter::exact('compost_gallons'),
                AllowedFilter::exact('water_foh_gallons'),
                AllowedFilter::exact('water_boh_gallons'),
                AllowedFilter::exact('farms_supported'),
                AllowedFilter::exact('tickets_sold'),
                AllowedFilter::scope('created_between'),
                AllowedFilter::scope('start_between'),
                AllowedFilter::scope('end_between'),
                AllowedFilter::scope('starts_after'),
                AllowedFilter::scope('ends_before'),
                AllowedFilter::exact('tags.content'),
            ])
            ->defaultSort('-start_date')
            ->allowedSorts('start_date')
            ->get();
    }

    public function scopeStartsAfter(Builder $query, $date): Builder
    {
        return $query->where('start_date', '>', array(Carbon::parse($date)));
    }

    public function scopeEndsBefore(Builder $query, $date): Builder
    {
        return $query->where('end_date', '<', array(Carbon::parse($date)));
    }

    public function scopeCreatedBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }

    public function scopeStartBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('start_date', array(Carbon::parse($from), Carbon::parse($to)));
    }

    public function scopeEndBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('end_date', array(Carbon::parse($from), Carbon::parse($to)));
    }
}
