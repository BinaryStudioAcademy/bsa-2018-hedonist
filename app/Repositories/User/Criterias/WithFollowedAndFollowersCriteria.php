<?php

namespace Hedonist\Repositories\User\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class WithFollowedAndFollowersCriteria implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        return $builder->with(['followers','followedUsers']);
    }
}