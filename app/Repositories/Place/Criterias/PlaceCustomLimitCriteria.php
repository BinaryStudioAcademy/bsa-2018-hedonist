<?php

namespace Hedonist\Repositories\Place\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class PlaceCustomLimitCriteria implements CriteriaInterface
{
    private $limit;

    public function __construct(int $limit)
    {
        $this->limit = $limit;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->limit($this->limit);
    }
}