<?php

namespace Hedonist\Actions\UserTaste;

class DeleteTasteRequest
{
    private $tasteId;

    public function __construct(int $tasteId)
    {
        $this->tasteId = $tasteId;
    }

    public function getTasteId(): int
    {
        return $this->tasteId;
    }
}