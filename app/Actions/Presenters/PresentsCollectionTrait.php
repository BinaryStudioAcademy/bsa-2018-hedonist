<?php

namespace Hedonist\Actions\Presenters;

use Illuminate\Support\Collection;

trait PresentsCollectionTrait
{
    public function presentCollection(Collection $collection): array
    {
        return $collection->map(function ($item) {
            return $item->present($item);
        })->toArray();
    }
}