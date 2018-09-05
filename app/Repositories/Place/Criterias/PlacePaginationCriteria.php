<?php

namespace Hedonist\Repositories\Place\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class PlacePaginationCriteria implements CriteriaInterface
{
    const LIMIT = 15;

    private $page;

    public function __construct(int $page)
    {
        $this->page = $page;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->offset(($this->page - 1) * self::LIMIT)->limit(self::LIMIT);
    }
}