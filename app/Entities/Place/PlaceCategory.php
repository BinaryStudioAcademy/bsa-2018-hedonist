<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceCategory extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table = 'place_categories';

    protected $fillable = ['name'];

    protected $dates = ['deleted_at'];
}