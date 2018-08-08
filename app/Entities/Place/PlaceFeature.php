<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceFeature extends Model
{
    use SoftDeletes;

    protected $table = 'places_features';
    
    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];

    public function places()
    {
        return $this->belongsToMany(
            Place::class,
            'places_places_features',
            'place_feature_id',
            'place_id'
        );
    }
}
