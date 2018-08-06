<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;
use Hedonist\Entities\Place\Place;
use Hedonist\User;

class PlaceRating extends Model
{
    public $timestamps = false;

    protected $table = 'place_rating';

    protected $fillable = ['user_id', 'place_id', 'rating'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
