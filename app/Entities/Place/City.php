<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 *
 * @property int $id
 * @property string $name
 */
class City extends Model
{
    protected $fillable = [
        'name',
        'longitude',
        'latitude'
    ];

    public function places()
    {
        return $this->hasMany(Place::class);
    }
}