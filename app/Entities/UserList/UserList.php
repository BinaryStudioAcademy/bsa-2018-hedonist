<?php

namespace Hedonist\Entities\UserList;

use Hedonist\Entities\UserList\Scope\UserListWithCreatorScope;
use Illuminate\Database\Eloquent\Model;
use Hedonist\Entities\User\User;
use Hedonist\Entities\Place\Place;
use Sleimanx2\Plastic\Searchable;

class UserList extends Model
{
    use Searchable;

    protected $table = 'user_lists';
    
    protected $fillable = ['user_id','name','img_url', 'is_default'];

    public $documentIndex = 'lists';

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

    public function buildDocument()
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user' => $this->user,
            'name' => $this->name,
            'img_url' => $this->img_url,
            'places' => $this->places
        ];
    }
}
