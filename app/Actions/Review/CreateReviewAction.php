<?php

namespace Hedonist\Actions\Review;

use Hedonist\Entities\Review\Review;
use Hedonist\Exceptions\User\UserNotFoundException;
use Hedonist\Repositories\User\UserRepositoryInterface;
use Hedonist\Repositories\Place\PlaceRepositoryInterface;
use Hedonist\Repositories\Review\ReviewRepositoryInterface;
use Hedonist\Exceptions\PlaceExceptions\PlaceDoesNotExistException;

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
        if (!$this->placeRepository->getById($request->getPlaceId())) {
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
        return new CreateReviewResponse($review);
    }
}
