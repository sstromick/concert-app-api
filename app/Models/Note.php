<?php
namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Note extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $with = ['tags', 'user'];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function noteable()
    {
        return $this->morphTo();
    }

    public static function getFilteredNotes($returnAll = false) {
        if ($returnAll)
            return QueryBuilder::for(Note::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('user_id'),
                    AllowedFilter::exact('noteable_id'),
                    AllowedFilter::scope('noteable_type'),
                    'content',
                    AllowedFilter::scope('created_between'),
                ]
                )
                ->get();
        else
            return QueryBuilder::for(Note::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('user_id'),
                    AllowedFilter::exact('noteable_id'),
                    AllowedFilter::scope('noteable_type'),
                    'content',
                    AllowedFilter::scope('created_between'),
                ]
                )
                ->paginate(20);
    }

    public function scopeNoteableType(Builder $query, $type): Builder
    {
        $fullType = "App\\Models\\" . $type;
        return $query->where('noteable_type', "=",  $fullType);
    }

    public function tags()
    {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }


    public function scopeCreatedBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }
}
