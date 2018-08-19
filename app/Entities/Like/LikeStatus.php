<?php

namespace Hedonist\Entities\Like;

final class LikeStatus
{
    const LIKED = 'LIKED';
    const DISLIKED = 'DISLIKED';
    const NONE = 'NONE';

    private $status;

    private function __construct(string $status)
    {
        $this->status = $status;
    }

    public function value(): string
    {
        return $this->status;
    }

    public static function liked(): self
    {
        return new self(self::LIKED);
    }

    public static function disliked(): self
    {
        return new self(self::DISLIKED);
    }

    public static function none(): self
    {
        return new self(self::NONE);
    }
}