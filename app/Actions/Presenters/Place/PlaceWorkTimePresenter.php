<?php

namespace Hedonist\Actions\Presenters\Place;

use Illuminate\Support\Collection;

class PlaceWorkTimePresenter
{
    private $presentation = [];

    public function present(Collection $worktime)
    {
        foreach ($worktime as $item) {
            $element = [
                $item->day_code => [
                    'start' => $item->start_time,
                    'end'   => $item->end_time
                ]
            ];
            $this->presentation[] = $element;
        }
        return $this->presentation;
    }
}