<?php

namespace Hedonist\Entities\Like;

class LikeStatus
{
    public function none(): string
    {
        return 'NONE';
    }

    public function liked(): string
    {
        return 'LIKED';
    }

    public function disliked(): string
    {
        return 'DISLIKED';
    }
}
