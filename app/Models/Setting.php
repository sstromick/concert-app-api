<?php

namespace App\Models;

use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Setting extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public static function getFilteredSettings($returnAll = false) {
        if ($returnAll)
            return QueryBuilder::for(Setting::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    'name',
                    'value',
                ]
                )
                ->get();
        else
            return QueryBuilder::for(Setting::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    'name',
                    'value',
                ]
                )
                ->paginate(20);
    }

}
