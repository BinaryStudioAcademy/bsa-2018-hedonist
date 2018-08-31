<?php

namespace Hedonist\Repositories\City;

use Hedonist\Entities\Place\City;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    public function model()
    {
        return City::class;
    }

    public function save(City $city): City
    {
        $city->save();

        return $city;
    }

    public function getById(int $id): ?City
    {
        return City::find($id);
    }

    public function findAll(): Collection
    {
        return City::all();
    }

    public function findByNameAndLocation(String $name, float $lng, float $lat): City
    {
        return City::firstOrCreate([
            'name' => $name,
            'longitude' => $lng,
            'latitude' => $lat
        ]);
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->getByCriteria($criteria);
    }

    public function deleteById(int $id)
    {
        $this->delete($id);
    }
}
