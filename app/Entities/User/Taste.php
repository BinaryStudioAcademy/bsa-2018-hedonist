<?php

namespace Hedonist\Entities\User;

use Illuminate\Database\Eloquent\Model;

class Taste extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function users()
    {
        $this->belongsToMany(User::class);
    }
}
