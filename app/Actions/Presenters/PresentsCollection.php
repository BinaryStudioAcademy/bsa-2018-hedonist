<?php

namespace Hedonist\Actions\Presenters;

use Illuminate\Support\Collection;

trait PresentsCollection
{
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(function ($item) {
            return $this->present($item);
        })->toArray();
    }
}