<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Contact extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $with = ['ContactMaster', 'tags', 'notes'];

    public function ContactMaster() {
        return $this->belongsTo('App\Models\ContactMaster');
    }

    public function venue() {
        return $this->belongsTo('App\Models\Venue');
    }

    public function NonProfit() {
        return $this->belongsTo('App\Models\NonProfit');
    }

    public function tags() {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function notes() {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public function contactable() {
        return $this->morphTo();
    }

    public static function getFilteredContacts($returnAll = false) {
        if ($returnAll)
            return QueryBuilder::for(Contact::class)
                ->allowedIncludes('contactable')
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('contactable_id'),
                    AllowedFilter::exact('tags.content'),
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::scope('contactable_type'),
                ]
                )
                ->get();
        else
            return QueryBuilder::for(Contact::class)
                ->allowedIncludes('contactable')
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('contactable_id'),
                    AllowedFilter::exact('tags.content'),
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::scope('contactable_type'),
                ]
                )
                ->paginate(20);
    }

    public function scopeCreatedBetween(Builder $query, $from, $to): Builder {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }

    public function scopeContactableType(Builder $query, $type): Builder {
        $fullType = "App\\Models\\" . $type;
        return $query->where('contactable_type', "=",  $fullType);
    }
}
