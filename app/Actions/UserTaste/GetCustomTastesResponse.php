<?php
namespace Hedonist\Actions\UserTaste;

use Illuminate\Database\Eloquent\Collection;

class GetCustomTastesResponse
{
    private $customTastes;

    public function __construct(Collection $customTastes)
    {
        $this->customTastes = $customTastes;
    }

    public function getCustomTastes(): array
    {
        return $this->customTastes->toArray();
    }
}