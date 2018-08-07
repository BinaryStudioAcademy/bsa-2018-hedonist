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
    public function getCollection()
    {
        return $this->collectionReviewPhoto;
    }
    public function toArray()
    {
        return $this->collectionReviewPhoto->toArray();
    }
}