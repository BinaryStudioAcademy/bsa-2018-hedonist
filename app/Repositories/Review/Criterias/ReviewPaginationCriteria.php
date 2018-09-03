<?php

namespace Hedonist\Repositories\Review\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ReviewPaginationCriteria implements CriteriaInterface
{
    const LIMIT = 10;

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