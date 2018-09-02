<?php

namespace Hedonist\Entities\Review\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ReviewRelationScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->with([
            'likes',
            'dislikes',
            'user',
            'user.info'
        ])->withCount([
            'likes',
            'dislikes',
        ]);
    }
}