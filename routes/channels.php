<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('reviews', function () {
    return true;
});

Broadcast::channel('place.{id}', function () {
    $auth = \Illuminate\Support\Facades\Auth::user();
    return [
        'id' => $auth->id,
        'first_name' => $auth->info->first_name,
        'last_name' => $auth->info->last_name,
        'email' => $auth->email,
        'avatar_url' => $auth->info->avatar_url,
    ];
});