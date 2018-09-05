<?php

namespace Hedonist\Repositories\Place\Criterias;

use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GetPlaceBySpecialFeatureCriteria implements CriteriaInterface
{
    private $featureIds;

    public function __construct(array $featureIds)
    {
        $this->featureIds = $featureIds;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        foreach ($this->featureIds as $featureId) {
            $model = $model->whereHas('features', function (Builder $query) use ($featureId) {
                $query->where('place_feature_id', $featureId);
            });
        }

        return $model;
    }
}