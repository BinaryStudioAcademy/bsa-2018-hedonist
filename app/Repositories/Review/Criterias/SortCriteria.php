<?php

namespace Hedonist\Repositories\Review\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class SortCriteria implements CriteriaInterface
{
    private $sort;
    private $order;

    public function __construct(string $sort, string $order = 'asc')
    {
        $this->sort = $sort;
        $this->order = $order;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->orderBy($this->sort, $this->order);
    }
}