<?php

namespace Hedonist\Actions\Review;

use Hedonist\Entities\Review\ReviewPhoto;

class SaveReviewPhotoResponse
{
    private $reviewPhoto;

    public function __construct(ReviewPhoto $reviewPhoto)
    {
        $this->reviewPhoto = $reviewPhoto;
    }

    public function getModel(): ReviewPhoto
    {
        return $this->reviewPhoto;
    }

    public function toArray(): array
    {
        return $this->reviewPhoto->toArray();
    }
}