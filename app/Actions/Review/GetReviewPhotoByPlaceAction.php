<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewPhotoRepositoryInterface;

class GetReviewPhotoByPlaceAction
{
    private $reviewPhotoRepository;

    public function __construct(ReviewPhotoRepositoryInterface $reviewPhotoRepository)
    {
        $this->reviewPhotoRepository = $reviewPhotoRepository;
    }

    public function execute(GetReviewPhotoByPlaceRequest $request): GetReviewPhotoByPlaceResponse
    {
        $reviewPhotos = $this->reviewPhotoRepository->getByPlace($request->getPlaceId());

        return new GetReviewPhotoByPlaceResponse($reviewPhotos);
    }
}