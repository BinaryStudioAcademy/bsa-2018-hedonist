<?php

namespace Hedonist\Entities\Place;

use Hedonist\Entities\User\Taste;
use Illuminate\Database\Eloquent\Model;

class PlaceTaste extends Model
{
    protected $fillable = ['taste_id', 'place_id'];

    public function taste()
    {
        return $this->belongsTo(Taste::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}