<?php

namespace Hedonist\Actions\Presenters\Place;

use Illuminate\Support\Collection;

class PlaceWorkTimePresenter
{
    private $presentation = [];

    public function present(Collection $worktime)
    {
        foreach ($worktime as $item) {
            $this->presentation[] = [
                    'day' => $item->day_code,
                    'start' => $item->start_time,
                    'end'   => $item->end_time
                ];
        }
        return $this->presentation;
    }
}