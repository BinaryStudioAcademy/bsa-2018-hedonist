<?php

namespace Hedonist\Repositories\Place\Criterias;

use Illuminate\Database\Eloquent\Relations\HasMany;
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
        $model->whereHas('lists',function(HasMany $relation){
            return $relation->where('id',$this->list);
        });
    }
}