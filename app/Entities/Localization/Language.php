<?php

namespace Hedonist\Entities\Localization;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        "code",
        "active",
        "default"
    ];

}
