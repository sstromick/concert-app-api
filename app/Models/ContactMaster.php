<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Log;

class ContactMaster extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = [];

    public function contacts() {
        return $this->hasMany('App\Models\Contact');
    }


    public static function getFilteredContactMasters($returnAll = false) {
        if ($returnAll)
            return QueryBuilder::for(ContactMaster::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    'name',
                    'title',
                    'email',
                    'phone',
                    AllowedFilter::scope('event'),
                    AllowedFilter::scope('artist'),
                    AllowedFilter::scope('venue'),
                    AllowedFilter::scope('nonprofit'),
                ]
                )
                ->orderBy('name', 'asc')
                ->get();
        else
            return QueryBuilder::for(ContactMaster::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    'name',
                    'title',
                    'email',
                    'phone',
                    AllowedFilter::scope('event'),
                    AllowedFilter::scope('artist'),
                    AllowedFilter::scope('venue'),
                    AllowedFilter::scope('nonprofit'),
                ]
                )
                ->orderBy('name', 'asc')
                ->paginate(20);
    }

    public function scopeEvent(Builder $query, $id): Builder
    {
        return $query->whereHas('contacts', function ($query) use ($id) {
                    $query->whereHasMorph('contactable', [Event::class], function ($query) use ($id) {
                            $query->where('id', $id);
                    });
                });
    }

    public function scopeArtist(Builder $query, $id): Builder
    {
        return $query->whereHas('contacts', function ($query) use ($id) {
                    $query->whereHasMorph('contactable', [Artist::class], function ($query) use ($id) {
                            $query->where('id', $id);
                    });
                });
    }

    public function scopeVenue(Builder $query, $id): Builder
    {
        return $query->whereHas('contacts', function ($query) use ($id) {
                    $query->whereHasMorph('contactable', [Venue::class], function ($query) use ($id) {
                            $query->where('id', $id);
                    });
                });
    }

    public function scopeNonprofit(Builder $query, $id): Builder
    {
        return $query->whereHas('contacts', function ($query) use ($id) {
                    $query->whereHasMorph('contactable', [NonProfit::class], function ($query) use ($id) {
                            $query->where('id', $id);
                    });
                });
    }

}
