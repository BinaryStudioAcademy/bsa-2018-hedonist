<?php
namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\Checkin;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;

interface CheckinRepositoryInterface
{
    public function save(Checkin $placesVisited) : Checkin;

    public function findAll() : Collection;

    public function getById(int $id) : ?Checkin;

    public function findByCriteria(CriteriaInterface $criteria) : Collection;

    public function deleteById(int $id);

    public function getByUserId(int $id): Collection;
}