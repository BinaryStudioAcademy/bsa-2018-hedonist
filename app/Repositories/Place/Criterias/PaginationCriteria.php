<?php

namespace Hedonist\Repositories\Place\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class PaginationCriteria implements CriteriaInterface
{
    private $limit;
    private $offset;

    /**
     * PaginationCriteria constructor.
     * @param $limit
     * @param $offset
     */
    public function __construct($limit, $offset)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }


    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->offset($this->offset)
            ->limit($this->limit)
//            ->with(
//                'category',
//                'category.tags',
//                'city',
//                'localization',
//                'localization.language',
//                'likes',
//                'dislikes',
//                'ratings'
//            )
            ;
    }
}