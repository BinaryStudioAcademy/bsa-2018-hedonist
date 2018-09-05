<?php

namespace Hedonist\Actions\Review;

use Hedonist\Entities\Review\Review;
use Hedonist\Exceptions\User\UserNotFoundException;
use Hedonist\Notifications\ReviewPlaceNotification;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;
use Hedonist\Exceptions\Place\PlaceDoesNotExistException;
use Illuminate\Support\Facades\Auth;
use Hedonist\Events\Review\ReviewAddEvent;

class CreateReviewAction
{
    private $userRepository;
    private $placeRepository;
    private $reviewRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        PlaceRepositoryInterface $placeRepository,
        ReviewRepositoryInterface $reviewRepository
    ) {
        $this->userRepository = $userRepository;
        $this->placeRepository = $placeRepository;
        $this->reviewRepository = $reviewRepository;
    }

    public function execute(CreateReviewRequest $request): CreateReviewResponse
    {
        $place = $this->placeRepository->getById($request->getPlaceId());
        if ($place === null) {
            throw new PlaceDoesNotExistException('Place does NOT exist!');
        }
        if (!$this->userRepository->getById($request->getUserId())) {
            throw UserNotFoundException::create();
        }

        $review = $this->reviewRepository->save(
            new Review(
                [
                    'user_id'       => $request->getUserId(),
                    'place_id'      => $request->getPlaceId(),
                    'description'   => $request->getDescription()
                ]
            )
        );

        broadcast(new ReviewAddEvent($review))->toOthers();
        $this->userRepository->getById($place->creator_id)
            ->notify(new ReviewPlaceNotification($place, Auth::user()));

        return new CreateReviewResponse($review);
    }
}
