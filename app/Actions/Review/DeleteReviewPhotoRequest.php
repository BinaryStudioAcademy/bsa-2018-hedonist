<?php

namespace Hedonist\Actions\Review;

class DeleteReviewPhotoRequest
{
    private $id;
    private $imgUrl;

    public function __construct(int $id, string $imgUrl)
    {
        $this->id = $id;
        $this->imgUrl = $imgUrl;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getImgUrl(): string
    {
        return $this->imgUrl;
    }
}