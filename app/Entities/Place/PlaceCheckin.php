<?php

namespace Hedonist\Entities\Place;

use Hedonist\Entities\User\User;
use Illuminate\Database\Eloquent\Model;

class PlaceCheckin extends Model
{
    protected $table = 'visited_places';

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
