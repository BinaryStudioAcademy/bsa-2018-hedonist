<?php

namespace Hedonist\Actions\UserTaste;

class DeleteCustomTasteRequest
{
    private $customTasteId;

    public function __construct(int $customTasteId)
    {
        $this->customTasteId = $customTasteId;
    }

    public function getCustomTasteId(): int
    {
        return $this->customTasteId;
    }
}