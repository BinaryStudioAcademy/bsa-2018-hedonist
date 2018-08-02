<?php

namespace Hedonist\Entity;

use Illuminate\Database\Eloquent\Model;

class FavouritePlace extends Model
{
    protected $table = 'favourite_places';
    protected $timestamps = false;

    /**
     * Get the user associated with the favourite place.
     */
    public function user()
    {
        return $this->belongsTo('Hedonist\Entity\User');
    }

    /**
     * Get the place associated with the favourite place.
     */
    public function place()
    {
        return $this->belongsTo('Hedonist\Entity\Place');
    }

    /**
     * @param $query
     * @param int $userId
     * @return mixed
     */
    public function scopeUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * @param $query
     * @param int $placeId
     * @return mixed
     */
    public function scopePlaceId($query, $placeId)
    {
        return $query->where('place_id', $placeId);
    }
}
