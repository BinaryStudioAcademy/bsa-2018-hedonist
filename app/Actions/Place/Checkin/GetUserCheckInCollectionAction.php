<?php

namespace Hedonist\Actions\Place\Checkin;

use Hedonist\Repositories\Place\CheckinRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRatingRepositoryInterface;
use Illuminate\Support\Facades\Auth;

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

        foreach ($checkIns as $key => $checkIn) {
            $checkIns[$key]->place->user_lists = $checkIn
                ->place
                ->lists()
                ->where('user_id', Auth::id())
                ->get();
            $checkIns[$key]->place->checkin_count = $checkIn
                ->place
                ->checkins
                ->count();
        }

        return new GetUserCheckInCollectionResponse($checkIns, $ratings);
    }
}