<?php

namespace Hedonist\Actions\Place\Checkin;

use Hedonist\Repositories\Place\CheckinRepository;

class GetUserCheckInCollectionAction
{
    private $checkInRepository;

    public function __construct(CheckinRepository $checkInRepository)
    {
        $this->checkInRepository = $checkInRepository;
    }

    public function execute(GetUserCheckInCollectionRequest $request): GetUserCheckInCollectionResponse
    {
        $checkIns = $this->checkInRepository->getByUserId($request->getUserId());

        return new GetUserCheckInCollectionResponse($checkIns);
    }
}