<?php

namespace Hedonist\Entities\Place;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $timestamps = false;

    protected $table = 'ratings';

    protected $fillable = ['rating'];
}