<?php

namespace Hedonist\Entities\User;

use Hedonist\Entities\User\Scope\UserScope;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Event;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tastes()
    {
        return $this->belongsToMany(Taste::class);
    }

    public function customTastes()
    {
        return $this->hasMany(CustomTaste::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function followedUsers()
    {
        return $this->belongsToMany(
            self::class,
            'follows',
            'follower_id',
            'followed_id'
        );
    }

    public function followers()
    {
        return $this->belongsToMany(
            self::class,
            'follows',
            'followed_id',
            'follower_id'
        );
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(new UserScope());

        self::deleting(function ($user) {
            $user->info->delete();
        });
    }
}
