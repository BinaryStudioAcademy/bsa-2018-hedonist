<?php

namespace Hedonist\Actions\Review;

use Illuminate\Http\UploadedFile;

class SaveReviewPhotoRequest
{
    private $id;
    private $description;
    private $img;
    private $review_id;

    public function __construct(int $review_id, string $description, UploadedFile $img, int $id = null)
    {
        $this->id = $id;
        $this->description = $description;
        $this->img = $img;
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

    public function getImg(): UploadedFile
    {
        return $this->img;
    }

    public function getReviewId(): int
    {
        return $this->review_id;
    }
}