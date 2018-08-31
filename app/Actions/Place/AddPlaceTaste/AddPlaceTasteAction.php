<?php

namespace Hedonist\Actions\Place\AddPlaceTaste;

use Hedonist\Entities\Place\PlaceTaste;
use Hedonist\Exceptions\Place\PlaceTasteExistException;
use Hedonist\Repositories\Place\PlaceTasteRepositoryInterface;

class AddPlaceTasteAction
{
    private $placeTasteRepository;

    public function __construct(PlaceTasteRepositoryInterface $placeTasteRepository)
    {
        $this->placeTasteRepository = $placeTasteRepository;
    }

    public function execute(AddPlaceTasteRequest $request): void
    {
        $placeId = $request->getPlaceId();
        $tasteId = $request->getTasteId();
        if ($this->placeTasteRepository->getByPlaceAndTaste($placeId, $tasteId)) {
            throw new PlaceTasteExistException();
        }

        $placeTaste = new PlaceTaste();
        $placeTaste->place_id = $placeId;
        $placeTaste->taste_id = $tasteId;
        $this->placeTasteRepository->save($placeTaste);
    }
}