<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table = 'ratings';

    protected $fillable = ['rating'];

    protected $dates = ['deleted_at'];
}