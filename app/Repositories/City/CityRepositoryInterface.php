<?php

namespace Hedonist\Repositories\City;

use Hedonist\Entities\Place\City;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;

interface CityRepositoryInterface
{
    public function save(City $placeCategory): City;

    public function getById(int $id) : ?City;

    public function findAll(): Collection;

    public function findByNameAndLocation(String $name, float $lng, float $lat): ?City;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function deleteById(int $id);
}
