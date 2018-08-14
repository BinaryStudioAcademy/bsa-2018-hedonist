<?php

namespace Hedonist\Repositories\Place;


use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class PlaceCategoryCriteria implements CriteriaInterface
{
    private $name;
    private $limit;

    public function __construct(string $name, int $limit)
    {
        $this->name = $name;
        $this->limit = $limit;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if (empty($this->name)) {
            return $model->limit($this->limit);
        }
        return $model->where('name', 'like', '%' . $this->name . '%')->limit($this->limit);
    }
}