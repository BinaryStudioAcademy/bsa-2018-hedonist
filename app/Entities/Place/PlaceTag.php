<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;

class PlaceTag extends Model
{
    protected $table = 'place_tag';
    public $timestamps = false;

    public function places()
    {
        return $this->belongsTo(Place::class);
    }

    public function categories()
    {
        return $this->belongsTo(PlaceCategoryTag::class);
    }

    public function scopePlace($q, int $placeId)
    {
        return $q->where('place_id', $placeId);
    }
}
