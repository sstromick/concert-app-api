<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Email extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['tags', 'notes'];

    public function NonProfitShift() {
        return $this->belongsTo('App\Models\NonProfitShift');
    }

    public function VolunteerShift() {
        return $this->belongsTo('App\Models\VolunteerShift');
    }

    public function shift() {
        return $this->belongsTo('App\Models\Shift');
    }

    public function EmailTemplate() {
        return $this->belongsTo('App\Models\EmailTemplate');
    }

    public function event() {
        return $this->belongsTo('App\Models\Event');
    }

    public function tags()
    {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function notes()
    {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public static function getFilteredEmails($returnAll = false) {
        if ($returnAll)
            return QueryBuilder::for(Email::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('event_id'),
                    AllowedFilter::exact('email_template_id'),
                    AllowedFilter::exact('non_profit_shift_id'),
                    AllowedFilter::exact('volunteer_shift_id'),
                    AllowedFilter::exact('delivered'),
                    'email',
                    'subject',
                    'body',
                    'error',
                    AllowedFilter::exact('tags.content'),
                    AllowedFilter::scope('created_between'),
                ]
                )
                ->get();
        else
            return QueryBuilder::for(Email::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('event_id'),
                    AllowedFilter::exact('email_template_id'),
                    AllowedFilter::exact('non_profit_shift_id'),
                    AllowedFilter::exact('volunteer_shift_id'),
                    AllowedFilter::exact('delivered'),
                    'email',
                    'subject',
                    'body',
                    'error',
                    AllowedFilter::exact('tags.content'),
                    AllowedFilter::scope('created_between'),
                ]
                )
                    ->paginate(20);
    }

    public function scopeCreatedBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }
}
