<?php

namespace Hedonist\Entities\User;

use Hedonist\Events\Auth\PasswordResetedEvent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Event;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, CanResetPasswordContract
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token)
    {
        Event::dispatch(new PasswordResetedEvent($this, $token));
    }

    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($user) {
            $user->info->delete();
        });
    }
}
