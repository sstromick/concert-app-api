<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Log;

class ShiftSchedule extends Model
{
    use SoftDeletes;

    protected $guarded = [];

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

    public static function getFilteredShiftSchedules() {
        return QueryBuilder::for(ShiftSchedule::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('shift_id'),
                AllowedFilter::exact('start_date'),
                AllowedFilter::exact('end_date'),
                AllowedFilter::exact('doors'),
                AllowedFilter::exact('check_in'),
                AllowedFilter::scope('created_between'),
                AllowedFilter::scope('start_between'),
                AllowedFilter::scope('end_between'),
            ]
            )
            ->get();
    }

}
