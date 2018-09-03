<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;

class PlaceInfo extends Model
{
    protected $table = 'place_info';

    protected $fillable = [
        'place_id',
        'work_weekend',
        'facebook',
        'instagram',
        'twitter',
        'menu_url'
    ];

    public function places()
    {
        return $this->belongsTo(Place::class);
    }
}
