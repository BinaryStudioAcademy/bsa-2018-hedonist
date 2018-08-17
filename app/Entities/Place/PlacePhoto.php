<?php

namespace Hedonist\Entities\Place;

use Hedonist\Entities\User\User;
use Illuminate\Database\Eloquent\Model;

class PlacePhoto extends Model
{
    protected $fillable = ['creator_id', 'img_url', 'description', 'place_id'];

    public function creator()
    {
        return $this->belongsTo(User::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}