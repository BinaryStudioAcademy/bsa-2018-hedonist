<?php

namespace Hedonist\Repositories\Place\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetPlaceByCategoryCriteria implements CriteriaInterface
{
    private $categoryId;

    public function __construct(int $categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('category_id', $this->categoryId);
    }
}