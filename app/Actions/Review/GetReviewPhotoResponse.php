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

    public function toArray(): array
    {
        return [
            'id' => $this->reviewPhoto->id,
            'description' => $this->reviewPhoto->description,
            'img_url' => $this->reviewPhoto->img_url,
            'review_id' => $this->reviewPhoto->review_id,
        ];
    }

    public function getId(): int
    {
        return $this->reviewPhoto->id;
    }

    public function getDescription(): string
    {
        return $this->reviewPhoto->description;
    }

    public function getImgUrl(): string
    {
        return $this->reviewPhoto->img_url;
    }

    public function getReviewId(): int
    {
        return $this->reviewPhoto->review_id;
    }
}