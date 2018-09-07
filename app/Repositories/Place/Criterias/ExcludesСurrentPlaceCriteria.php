<?php

namespace Hedonist\Repositories\Place\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ExcludesСurrentPlaceCriteria implements CriteriaInterface
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('id', '!=', $this->id);
    }
}