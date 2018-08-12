<?php

namespace Hedonist\Actions\Place\Checkin;

use Hedonist\Exceptions\Place\PlaceNotFoundException;
use Hedonist\Exceptions\User\UserNotFoundException;
use Hedonist\Repositories\Place\CheckinRepositoryInterface;
use Hedonist\Entities\Place\Checkin;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class SetCheckinAction
{
    protected $repository;
    protected $placeRepository;
    private $userId;

    public function __construct(CheckinRepositoryInterface $repository, PlaceRepositoryInterface $placeRepository)
    {
        $this->repository = $repository;
        $this->placeRepository = $placeRepository;
        $this->userId = Auth::id();
    }

    public function execute(SetCheckinRequest $request): SetCheckinResponse
    {
        $userId = $request->getUserId();
        $userId = $userId ?: $this->userId;
        $placeId = $request->getPlaceId();

        throw_if(! $userId, new UserNotFoundException('User not found'));
        throw_if(
            ! $this->placeRepository->getById($placeId),
            new PlaceNotFoundException('Place not found')
        );

        $checkin = new Checkin([
            'user_id' => $userId,
            'place_id' => $placeId,
        ]);

        $checkin = $this->repository->save($checkin);

        return new SetCheckinResponse(
            $checkin->id,
            $checkin->user_id,
            $checkin->place_id
        );
    }
}
