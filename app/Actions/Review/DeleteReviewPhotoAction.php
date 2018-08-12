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
        if (! $reviewPhoto) {
            throw new ReviewPhotoExistsException('Review photo not found.');
        }
        $arr = explode('/', $reviewPhoto->img_url);
        Storage::disk('public')->delete('upload/review/' . end($arr));
        $this->reviewPhotoRepository->deleteById($id);
    }
}