<?php

namespace Hedonist\Actions\Like;

class LikePlaceResponse
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
