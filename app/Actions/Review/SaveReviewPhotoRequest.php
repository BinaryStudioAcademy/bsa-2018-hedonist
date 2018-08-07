<?php

namespace Hedonist\Actions\Review;

class SaveReviewPhotoRequest
{
    private $id;
    private $description;
    private $img_url;
    private $review_id;

    public function __construct(int $review_id, string $description, string $img_url, int $id = null)
    {
        $this->id = $id;
        $this->description = $description;
        $this->img_url = $img_url;
        $this->review_id = $review_id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getImgUrl(): string
    {
        return $this->img_url;
    }

    public function getReviewId(): int
    {
        return $this->review_id;
    }
}