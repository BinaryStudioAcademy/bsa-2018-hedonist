<?php

namespace Hedonist\Entities\User;

use Illuminate\Database\Eloquent\Model;

class CustomTaste extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
