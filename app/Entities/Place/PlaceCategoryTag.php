<?php

namespace Hedonist;

use Hedonist\Entities\Place\PlaceCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceCategoryTag extends Model
{
    use SoftDeletes;

    protected $table = 'place_categories_tags';

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];

    public function categories()
    {
        return $this->belongsToMany(
            PlaceCategory::class,
            'place_category_place_tag',
            'place_tag_id',
            'place_category_id'
        );
    }
}
