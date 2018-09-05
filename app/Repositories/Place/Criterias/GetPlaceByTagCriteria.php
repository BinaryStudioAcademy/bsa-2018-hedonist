<?php

namespace Hedonist\Repositories\Place\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetPlaceByTagCriteria implements CriteriaInterface
{
    private $tagIds;

    public function __construct(array $tagIds)
    {
        $this->tagIds = $tagIds;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereHas('tags', function ($query) {
            $query->whereIn('tag_id', $this->tagIds);
        });
    }
}