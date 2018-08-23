<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;

class PlaceInfo extends Model
{
    protected $table = 'place_info';

    public function places()
    {
        return $this->belongsTo(Place::class);
    }
}
