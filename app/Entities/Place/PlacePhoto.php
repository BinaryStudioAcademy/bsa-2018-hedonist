<?php

namespace Hedonist\Entities\Place;

use Hedonist\Entities\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;

class PlacePhoto extends Model
{
    protected $fillable = ['creator_id', 'img_url', 'description', 'place_id', 'width', 'height'];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function scopePlace(QueryBuilder $q, int $placeId)
    {
        return $q->where('place_id', $placeId);
    }
}