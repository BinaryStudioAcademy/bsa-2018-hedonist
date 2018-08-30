<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Entities\User\CustomTaste;

class AddCustomTasteResponse
{
    private $customTaste;

    public function __construct(CustomTaste $customTaste)
    {
        $this->customTaste = $customTaste;
    }

    public function getTaste(): array
    {
        return $this->customTaste->toArray();
    }
}