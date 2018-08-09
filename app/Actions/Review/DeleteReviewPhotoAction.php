<?php

namespace Hedonist\Actions\Review;

use Hedonist\Repositories\Review\ReviewPhotoRepository;
use Illuminate\Support\Facades\Storage;

class DeleteReviewPhotoAction
{
    private $reviewPhotoRepository;

    public function __construct(ReviewPhotoRepository $reviewPhotoRepository)
    {
        $this->reviewPhotoRepository = $reviewPhotoRepository;
    }

    public function execute(DeleteReviewPhotoRequest $request): void
    {
        Storage::delete('public/upload/review/' . $request->getImgUrl());
        $this->reviewPhotoRepository->deleteById($request->getId());
    }
}