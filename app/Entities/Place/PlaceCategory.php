<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class PlaceCategory extends Model implements Transformable
{
    use TransformableTrait;

    protected $table = 'place_categories';

    protected $fillable = ['name'];

    /*
    public function places() {
        return $this->hasMany(Place::class);
      }
    
    public function place_category_tags() {
        return $this->hasMany(PlaceCategoryTag::class);
    }
    */
}
