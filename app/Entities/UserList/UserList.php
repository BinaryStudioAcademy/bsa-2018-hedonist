<?php

namespace Hedonist\Entities\UserList;

use Hedonist\Entities\UserList\Scope\UserListWithCreatorScope;
use Illuminate\Database\Eloquent\Model;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\Place;

class UserList extends Model
{
    protected $table = 'user_lists';
    
    protected $fillable = ['user_id','name','img_url'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserListWithCreatorScope());
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
