<?php

namespace Hedonist\Actions\Place\Checkin;

use Hedonist\Repositories\Place\CheckinRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GetUserCheckInCollectionAction
{
    private $checkInRepository;

    public function __construct(CheckinRepositoryInterface $checkInRepository)
    {
        $this->checkInRepository = $checkInRepository;
    }

    public function execute(GetUserCheckInCollectionRequest $request): GetUserCheckInCollectionResponse
    {
        $checkIns = $this->checkInRepository->getByUserId($request->getUserId());

        return new GetUserCheckInCollectionResponse($this->transformCollection($checkIns));
    }

    private function transformCollection(Collection $checkIns): Collection
    {
        return $checkIns->map(function($checkIn) {
            $checkIn->place['avgRating'] = $checkIn->place->ratings->avg('rating');
            return $checkIn;
        });
    }
}