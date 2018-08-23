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
            'city',
            'category',
            'category.tags',
            'features',
            'localization',
        ]);
    }
}
