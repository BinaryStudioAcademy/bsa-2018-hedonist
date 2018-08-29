<?php

namespace Hedonist\Repositories\Place\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetPlaceByUserListCriteria implements CriteriaInterface
{
    private $list;

    public function __construct(int $id)
    {
        $this->list = $id;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereHas('lists',function(Builder $relation){
            return $relation->where('user_lists.id',$this->list);
        });
    }
}