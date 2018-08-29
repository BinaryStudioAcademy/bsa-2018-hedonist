<?php

namespace Hedonist\Entities\User;

use Illuminate\Database\Eloquent\Model;

class Taste extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'is_default'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
