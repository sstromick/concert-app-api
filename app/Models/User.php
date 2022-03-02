<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $dates = ['deleted_at'];

    protected $with = ['notes', 'tags'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function tags()
    {
        return $this->morphMany('App\Models\Tag', 'tagable');
    }

    public function notes()
    {
        return $this->morphMany('App\Models\Note', 'noteable');
    }

    public static function getFilteredUsers($returnAll = false) {
        if ($returnAll) {
            return QueryBuilder::for(User::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('email_verified_at'),
                    AllowedFilter::exact('active'),
                    'first_name',
                    'last_name',
                    'email',
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::exact('tags.content'),
                ]
                )
                ->get();
        }
        else {
            return QueryBuilder::for(User::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('email_verified_at'),
                    AllowedFilter::exact('active'),
                    'first_name',
                    'last_name',
                    'email',
                    AllowedFilter::scope('created_between'),
                    AllowedFilter::exact('tags.content'),
                ]
                )
                ->paginate(20);
        }
    }

    public function scopeCreatedBetween(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', array(Carbon::parse($from), Carbon::parse($to)));
    }
}
