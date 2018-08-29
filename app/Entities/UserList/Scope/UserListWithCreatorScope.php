<?php

namespace Hedonist\Entities\UserList\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class UserListWithCreatorScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->with('user');
    }
}