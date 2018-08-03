<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PlaceCategory extends Model implements Transformable
{
    use TransformableTrait;

    public $timestamps = false;

    protected $table = 'place_categories';

    protected $fillable = ['name'];
}
