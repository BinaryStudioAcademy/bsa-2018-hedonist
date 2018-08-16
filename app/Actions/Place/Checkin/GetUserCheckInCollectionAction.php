<?php

namespace Hedonist\Actions\Place\Checkin;

use Hedonist\Repositories\Place\CheckinRepositoryInterface;

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

        return new GetUserCheckInCollectionResponse($checkIns);
    }
}