<?php

namespace Hedonist\Repositories\Place\Criterias;

use Hedonist\Entities\Place\Place;
use Hedonist\Exceptions\DomainException;
use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class GetPlaceByPlaceTastesCriteria implements CriteriaInterface
{
    private $currentPlace;

    public function __construct(Place $currentPlace)
    {
        $this->currentPlace = $currentPlace;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $placeTastes = $this->currentPlace->tastes->pluck('id')->toArray();
        if (!empty($placeTastes)) {
            $model = $model->whereHas('tastes', function (Builder $query) use ($placeTastes) {
                $query->whereIn('place_tastes.taste_id', $placeTastes);
            });
        }

        return $model;
    }
}