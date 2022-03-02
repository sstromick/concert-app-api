<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class EmailTemplate extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['emails', 'tags', 'notes'];

    public function emails() {
        return $this->hasMany('App\Models\Email');
    }

    public function event() {
        return $this->belongsTo('App\Models\Event');
    }

    public function shift() {
        return $this->belongsTo('App\Models\Shift');
    }

    public function tags()
    {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function notes()
    {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public static function getFilteredEmailTemplates() {
        return QueryBuilder::for(EmailTemplate::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('event_id'),
                AllowedFilter::exact('shift_id'),
                'subject',
                'body',
                'event_type',
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
