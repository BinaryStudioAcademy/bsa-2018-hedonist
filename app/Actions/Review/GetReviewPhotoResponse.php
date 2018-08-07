<?php

namespace Hedonist\Actions\Review;

use Hedonist\Entities\Review\ReviewPhoto;

class GetReviewPhotoResponse
{
    private $reviewPhoto;

    public function __construct(ReviewPhoto $reviewPhoto)
    {
        $this->reviewPhoto = $reviewPhoto;
    }

    public function toArray()
    {
        return [
            'id' => $this->reviewPhoto->id,
            'description' => $this->reviewPhoto->description,
            'img_url' => $this->reviewPhoto->img_url,
            'review_id' => $this->reviewPhoto->review_id,
        ];
    }
}