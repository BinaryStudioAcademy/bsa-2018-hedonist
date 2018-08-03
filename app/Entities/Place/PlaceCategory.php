<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;

class PlaceCategory extends Model implements Transformable
{
    public $timestamps = false;

    protected $table = 'place_categories';

    protected $fillable = ['name'];
}
