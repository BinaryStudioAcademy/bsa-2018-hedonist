<?php

namespace Hedonist\Actions\Review;

class GetReviewPhotoRequest
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }
}