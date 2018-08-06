<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;

class PlaceRating extends Model
{
    public $timestamps = false;

    protected $table = 'place_rating';

    protected $fillable = ['rating'];
}