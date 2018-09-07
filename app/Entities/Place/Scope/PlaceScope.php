<?php

namespace Hedonist\Entities\Place\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PlaceScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->with([
            'category',
            'city',
            'features',
            'localization',
            'localization.language',
            'ratings',
            'tags',
            'worktime',
        ]);
    }
}
