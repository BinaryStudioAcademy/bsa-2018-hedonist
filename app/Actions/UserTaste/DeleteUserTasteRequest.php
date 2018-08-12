<?php

namespace Hedonist\Actions\UserTaste;

class DeleteUserTasteRequest
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