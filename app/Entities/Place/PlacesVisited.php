<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;

class PlacesVisited extends Model
{
    protected $table = 'places_visiteds';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'place_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
