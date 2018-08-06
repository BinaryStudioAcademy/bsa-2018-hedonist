<?php

namespace Hedonist\Repositories\Place;


use Hedonist\Entities\Place\PlacesVisited;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface PlacesVisitedRepositoryInterface
{
    public function save(PlacesVisited $placesVisited) : PlacesVisited;

    public function findAll() : Collection;

    public function getById(int $id) : ?PlacesVisited;

    public function findByCriteria(CriteriaInterface $criteria) : Collection;

    public function deleteById(int $id);

}