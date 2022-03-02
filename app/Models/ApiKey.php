<?php

namespace App\Models;

use App\Models\ApiKey;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiKey extends Model {
    use SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'api_key',
    ];

    protected $dates = ['deleted_at'];

    public static function getFilteredApiKeys() {
        return QueryBuilder::for(ApiKey::class)
            ->allowedFilters(
                Filter::exact('id'),
                Filter::exact('secret_key'),
                Filter::exact('active')
            )
            ->get();
    }
}
