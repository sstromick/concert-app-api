<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class VolunteerShift extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['volunteer', 'tags', 'notes'];

    public function shift() {
        return $this->belongsTo('App\Models\Shift');
    }

    public function volunteer() {
        return $this->belongsTo('App\Models\Volunteer')->setEagerLoads([]);
    }

    public function tags()
    {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function notes()
    {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public static function getFilteredVolunteerShifts() {
        return QueryBuilder::for(VolunteerShift::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('shift_id'),
                AllowedFilter::exact('volunteer_id'),
                AllowedFilter::exact('attended'),
                AllowedFilter::exact('waitlist'),
                AllowedFilter::exact('accepted'),
                AllowedFilter::exact('accepted_at'),
                AllowedFilter::exact('declined'),
                AllowedFilter::exact('declined_at'),
                AllowedFilter::exact('confirmed'),
                AllowedFilter::exact('confirmed_at'),
                AllowedFilter::exact('pending'),
                AllowedFilter::exact('roll_call'),
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
