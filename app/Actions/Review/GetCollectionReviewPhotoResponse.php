<?php

namespace Hedonist\Actions\Review;

use Illuminate\Database\Eloquent\Collection;

class GetCollectionReviewPhotoResponse
{
    private $collectionReviewPhoto;

    public function __construct(Collection $collectionReviewPhoto)
    {
        $this->collectionReviewPhoto = $collectionReviewPhoto;
    }
    public function getCollection(): Collection
    {
        return $this->collectionReviewPhoto;
    }
    public function toArray(): array
    {
        return $this->collectionReviewPhoto->toArray();
    }
}