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
            'tags',
            'city',
            'localization',
            'localization.language',
            'likes',
            'photos',
            'dislikes',
            'ratings',
            'worktime',
            'reviews',
            'features',
            'category.tags',
            'checkins'
        ]);
    }
}
