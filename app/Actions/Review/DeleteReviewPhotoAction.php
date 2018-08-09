<?php

namespace Hedonist\Actions\Review;

use Hedonist\Exceptions\Review\ReviewPhotoExistsException;
use Hedonist\Repositories\Review\ReviewPhotoRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class DeleteReviewPhotoAction
{
    private $reviewPhotoRepository;

    public function __construct(ReviewPhotoRepositoryInterface $reviewPhotoRepository)
    {
        $this->reviewPhotoRepository = $reviewPhotoRepository;
    }

    public function execute(DeleteReviewPhotoRequest $request): void
    {
        $id = $request->getId();
        $reviewPhoto = $this->reviewPhotoRepository->getById($id);
        if (!$reviewPhoto) {
            throw new ReviewPhotoExistsException('Review photo not found.');
        }
        Storage::delete('public/upload/review/' . $reviewPhoto->img_url);
        $this->reviewPhotoRepository->deleteById($id);
    }
}