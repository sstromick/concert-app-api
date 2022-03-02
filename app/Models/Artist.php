<?php

namespace App\Models;

use Carbon\Carbon;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Artist extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['events','shifts', 'contacts', 'tags', 'notes'];

    public function events() {
        return $this->hasMany('App\Models\Event');
    }

    public function shifts() {
        return $this->hasMany('App\Models\Shift');
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

    public static function getFilteredArtists($returnAll = false) {
        if ($returnAll)
            return QueryBuilder::for(Artist::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    'name',
                    'photo_url',
                    AllowedFilter::exact('tags.content'),
                    AllowedFilter::scope('created_between'),
                ]
                )
                ->orderBy('name', 'asc')
                ->get();
        else
            return QueryBuilder::for(Artist::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    'name',
                    'photo_url',
                    AllowedFilter::exact('tags.content'),
                    AllowedFilter::scope('created_between'),
                ]
                )
                ->orderBy('name', 'asc')
                ->paginate(20);
    }

    public function scopeCreatedBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }
}
