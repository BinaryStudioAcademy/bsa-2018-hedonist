<?php

namespace Hedonist\Actions\UserTaste;

use Hedonist\Entities\User\Taste;

class AddUserTasteResponse
{
    private $taste;

    public function __construct(Taste $taste)
    {
        $this->taste = $taste;
    }

    public function getTaste(): array
    {
        return $this->taste->toArray();
    }
}