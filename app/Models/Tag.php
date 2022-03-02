<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Log;

class Tag extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['notes'];

    public function tagable(){
        return $this->morphTo();
    }

    public function tags() {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function notes() {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public static function getFilteredTags() {
        return QueryBuilder::for(Tag::class)
            ->allowedFilters([
                AllowedFilter::exact('id'),
                AllowedFilter::exact('tagable_id'),
                AllowedFilter::scope('tagable_type'),
                'content',
                AllowedFilter::scope('created_between'),
            ])
            ->paginate(20);
    }

    public function scopeTagableType(Builder $query, $type): Builder {
        $fullType = "App\\Models\\" . $type;
        return $query->where('tagable_type', "=",  $fullType);
    }

    public function scopeCreatedBetween(Builder $query, $from, $to): Builder {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }
}
