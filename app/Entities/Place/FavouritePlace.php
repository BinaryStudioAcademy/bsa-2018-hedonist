<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;

class FavouritePlace extends Model
{
    protected $table = 'favourite_places';
    protected $fillable = ['user_id', 'place_id'];
    protected $timestamps = false;

    public function user()
    {
        return $this->belongsTo('Hedonist\Entities\User');
    }

    public function place()
    {
        return $this->belongsTo('Hedonist\Entities\Place');
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
