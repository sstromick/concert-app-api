<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Country extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'ISO2',
    ];

    protected $with = ['states', 'tags', 'notes'];

    public function states() {
        return $this->hasMany('App\Models\State');
    }

    public function venues() {
        return $this->hasMany('App\Models\Venue');
    }

    public function volunteers() {
        return $this->hasMany('App\Models\Volunteer');
    }

    public function nonprofits() {
        return $this->hasMany('App\Models\Nonprofit');
    }

    public function tags()
    {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function notes()
    {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public static function getFilteredCountries() {
        return QueryBuilder::for(Country::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('ISO2'),
                'name',
                AllowedFilter::exact('tags.content'),
                AllowedFilter::scope('created_between'),
            ]
            )
            ->get();
    }

    public function scopeCreatedBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }
}
