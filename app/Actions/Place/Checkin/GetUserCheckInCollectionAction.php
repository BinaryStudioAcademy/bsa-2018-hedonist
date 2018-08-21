<?php

namespace Hedonist\Actions\Place\Checkin;

use Hedonist\Repositories\Place\CheckinRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;

class GetUserCheckInCollectionAction
{
    private $checkInRepository;
    private $ratingRepository;

    public function __construct(
        CheckinRepositoryInterface $checkInRepository,
        PlaceRatingRepositoryInterface $ratingRepository
    ) {
        $this->checkInRepository = $checkInRepository;
        $this->ratingRepository = $ratingRepository;
    }

    public function execute(GetUserCheckInCollectionRequest $request): GetUserCheckInCollectionResponse
    {
        $checkIns = $this->checkInRepository->getByUserId($request->getUserId());
        $ratings = $this->ratingRepository
            ->getAvgByPlaceIds($checkIns->pluck('place_id')->all());

        return new GetUserCheckInCollectionResponse($checkIns, $ratings);
    }
}