<?php
namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\PlaceCheckin;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface PlaceCheckinRepositoryInterface
{
    public function save(PlaceCheckin $placesVisited) : PlaceCheckin;

    public function findAll() : Collection;

    public function getById(int $id) : ?PlaceCheckin;

    public function findByCriteria(CriteriaInterface $criteria) : Collection;

    public function deleteById(int $id);

}