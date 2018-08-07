<?php

namespace Hedonist\Actions\Place;


use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetPlaceCollectionAction
{
    protected $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository)
    {
        $this->placeRepository = $placeRepository;
    }

    public function execute(): GetPlaceCollectionResponse
    {
        $places = $this->placeRepository->findAll();
        $placesCollection = $this->transformCollection($places);

        return new GetPlaceCollectionResponse($placesCollection);
    }

    /**
     * Transform items fields and pulled dependent values (category name, creator name, city)
     * from db so when we send collection to response there were no requests to db
     *
     * @param Collection $places
     * @return Collection
     */
    private function transformCollection(Collection $places): Collection
    {
        return $places->transform(function($place) {
            return [
                'id'         => $place->id,
                'creator'    => $place->creator->email,
                'category'   => $place->category->name,
                'city'       => $place->city->name,
                'longitude'  => $place->longitude,
                'latitude'   => $place->latitude,
                'zip'        => $place->zip,
                'place'      => $place->address,
                'created_at' => $place->created_at,
                'updated_at' => $place->updated_at
            ];
        });
    }
}
