<?php

namespace Hedonist\Repositories\Place;

use Hedonist\Entities\Place\Location;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Database\Eloquent\Collection;
use Hedonist\Entities\Place\Place;

interface PlaceRepositoryInterface
{
    public function save(Place $placeCategory): Place;

    public function getById(int $id): ?Place;

    public function getByIdWithRelations(int $id): ?Place;

    public function findAll(): Collection;

    public function findByCriteria(CriteriaInterface $criteria): Collection;

    public function getAllWithRelations(): Collection;

    public function findByCoordinates(Location $center, float $radius): Collection;

    public function getByList(int $listId): Collection;

    public function deleteById(int $id): void;

    public function findCollectionByCriterias(CriteriaInterface ...$criterias): Collection;

    public function setTranslations(Place $place, array $localizations): void;

    public function syncTags(Place $place, array $tags): void;

    public function syncFeatures(Place $place, array $features): void;

    public function setWorktime(Place $place, array $worktime): void;

    public function getPlaceCheckinsCountByUser(int $placeId, int $userId) : int;

    public function findCountByCriterias(CriteriaInterface ...$criterias): int;
}
