<?php
namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $table = 'tags';

    protected $fillable = [
        'name'
    ];

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
