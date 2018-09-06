<?php

namespace Hedonist\Entities\UserList;

use Hedonist\Entities\Place\Place;
use Hedonist\Entities\User\User;
use Hedonist\Entities\UserList\Scope\FavouriteListScope;
use Illuminate\Database\Eloquent\Model;

class FavouriteList extends Model
{
    const FAVOURITE_LIST_NAME = 'Favourite';

    protected $table = 'user_lists';
    protected $fillable = ['user_id','name','img_url', 'is_default'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new FavouriteListScope());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function places()
    {
        return $this->belongsToMany(
            Place::class,
            'user_list_places',
            'list_id',
            'place_id'
        );
    }
}
