<?php

namespace Hedonist\Repositories\Review\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetReviewsByTextCriteria implements CriteriaInterface
{
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('description', 'like', "%{$this->text}%");
    }
}