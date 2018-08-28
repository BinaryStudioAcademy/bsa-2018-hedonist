<?php

namespace Hedonist\Repositories\Place\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetPlaceByNameCriteria implements CriteriaInterface
{
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $name = $this->name;
        return $model->whereHas('localization', function($q) use($name) {
            $q->where('place_name', 'like', "%{$name}%");
        });
    }
}