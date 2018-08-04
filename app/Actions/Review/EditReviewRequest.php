<?php

namespace Hedonist\Actions\Review;

class EditReviewRequest
{
    private $body;
    private $title;

    public function __construct(string $title, string $body)
    {
        $this->title = $title;
        $this->body = $body;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
