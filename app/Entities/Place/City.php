<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        "name"
    ];

    public function places()
    {
        return $this->hasMany(Place::class);
    }
}