<?php

namespace Hedonist\Entities\UserList\Scope;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class FavouriteListScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where([
            ['name', '=', 'Favourite'],
            ['is_default', '=', true]
        ]);
    }
}