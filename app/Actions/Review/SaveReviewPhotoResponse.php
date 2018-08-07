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

    public function getModel()
    {
        return $this->reviewPhoto;
    }

    public function toArray()
    {
        return $this->reviewPhoto->toArray();
    }
}