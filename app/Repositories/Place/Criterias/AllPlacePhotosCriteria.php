<?php

namespace Hedonist\Repositories\Place\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class AllPlacePhotosCriteria implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->with('photos');
    }
}