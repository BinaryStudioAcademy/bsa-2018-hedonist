<?php

namespace Hedonist\Entities\UserList\Scope;

use Hedonist\Entities\UserList\FavouriteList;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class FavouriteListScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where([
            ['name', '=', FavouriteList::FAVOURITE_LIST_NAME],
            ['is_default', '=', true]
        ]);
    }
}