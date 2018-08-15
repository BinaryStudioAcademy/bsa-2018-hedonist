<?php

namespace Hedonist\Entities\Localization;

use Hedonist\Entities\Place\Place;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlaceTranslation
 *
 * @property string $place_name
 * @property string $place_description
 * @property int $place_id
 * @property int $language_id
 */
class PlaceTranslation extends Model
{
    protected $table = "places_tr";

    protected $fillable = [
        "place_name",
        "place_description",
        "place_id",
        "language_id"
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
