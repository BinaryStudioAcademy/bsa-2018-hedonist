<?php

namespace Hedonist\Actions\Review;

use Illuminate\Database\Eloquent\Collection;

class GetReviewPhotoByReviewResponse
{
    private $reviewPhotos;

    public function __construct(Collection $reviewPhotos)
    {
        $this->reviewPhotos = $reviewPhotos;
    }

    public function getCollection(): Collection
    {
        return $this->reviewPhotos;
    }

    public function toArray(): array
    {
        return $this->reviewPhotos->toArray();
    }
}