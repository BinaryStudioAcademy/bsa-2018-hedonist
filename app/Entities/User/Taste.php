<?php

namespace Hedonist\Entities\User;

use Illuminate\Database\Eloquent\Model;

class Taste extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
