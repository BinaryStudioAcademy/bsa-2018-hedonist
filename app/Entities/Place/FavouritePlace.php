<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;
use Hedonist\Entities\Place\Place;
use Hedonist\Entities\User\User;

class FavouritePlace extends Model
{
    protected $table = 'favourite_places';
    protected $fillable = ['user_id', 'place_id'];
    protected $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function scopeUserId($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePlaceId($query, int $placeId)
    {
        return $query->where('place_id', $placeId);
    }
}
