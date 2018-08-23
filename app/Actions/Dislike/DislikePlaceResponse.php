<?php

namespace Hedonist\Actions\Dislike;

class DislikePlaceResponse
{
    private $likes;
    private $dislikes;

    public function __construct(int $likes, int $dislikes)
    {
        $this->likes = $likes;
        $this->dislikes = $dislikes;
    }

    public function getLikes()
    {
        return $this->likes;
    }

    public function getDislikes()
    {
        return $this->dislikes;
    }
}
