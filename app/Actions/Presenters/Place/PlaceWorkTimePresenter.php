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
                    'day'   => $this->getDayName($item->day_code),
                    'start' => $item->start_time,
                    'end'   => $item->end_time
                ];
        }
        return $this->presentation;
    }

    private function getDayName(string $day_code): string
    {
        switch ($day_code) {
            case 'mo':
                return 'Monday';
            case 'tu':
                return 'Tuesday';
            case 'we':
                return 'Wednesday';
            case 'th':
                return 'Thursday';
            case 'fr':
                return 'Friday';
            case 'sa':
                return 'Saturday';
            case 'su':
                return 'Sunday';
        }
    }
}