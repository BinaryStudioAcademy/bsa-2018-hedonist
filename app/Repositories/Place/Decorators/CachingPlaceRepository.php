<?php

namespace Hedonist\Repositories\Place\Decorators;

use Hedonist\Entities\Place\Location;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\Place;

class PlaceRepository implements PlaceRepositoryInterface
{
    protected $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function save(Place $place): Place
    {
        return $this->placeRepository->save($place);
    }

    public function getById(int $id): ?Place
    {
        return $this->placeRepository->getById($id);
    }

    public function getByIdWithRelations(int $id): ?Place
    {
        return $this->placeRepository->getByIdWithRelations($id);
    }

    public function findAll(): Collection
    {
        return $this->placeRepository->findAll();
    }

    public function getAllWithRelations(): Collection
    {
        return $this->placeRepository->getAllWithRelations();
    }

    public function findByCriteria(CriteriaInterface $criteria): Collection
    {
        return $this->placeRepository->findByCriteria($criteria);
    }

    public function findByCoordinates(Location $center, float $radius): Collection
    {
        return $this->placeRepository->findByCoordinates($center, $radius);
    }

    public function deleteById(int $id): void
    {
        $this->placeRepository->deleteById($id);
    }

    public function getByList(int $listId): Collection
    {
        return $this->placeRepository->getByList($listId);
    }

    public function findCollectionByCriterias(CriteriaInterface ...$criterias): Collection
    {
        return $this->placeRepository->findCollectionByCriterias(...$criterias);
    }

    public function setTranslations(Place $place, array $localizations): void
    {
        $this->placeRepository->setTranslations($place, $localizations);
    }

    public function syncTags(Place $place, array $tags): void
    {
        $this->placeRepository->setTranslations($place, $tags);
    }

    public function syncFeatures(Place $place, array $features): void
    {
        $this->placeRepository->syncFeatures($place, $features);
    }

    public function setWorktime(Place $place, array $worktime): void
    {
        $this->placeRepository->syncFeatures($place, $worktime);
    }

    public function getPlaceCheckinsCountByUser(int $placeId, int $userId) : int
    {
        $this->placeRepository->getPlaceCheckinsCountByUser($placeId, $userId);
    }
}