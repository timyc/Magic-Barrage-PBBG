<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Session;

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

Broadcast::channel('character.{id}', function ($user, $id) {
    // check if session character matches the id
    return (int) Session::get('characterId') === (int) $id;
});

Broadcast::channel('clan.{id}', function ($user, $id) {
    // check if session character is in the clan
    return (int) Session::get('clan')->id === (int) $id;
});

Broadcast::channel('globalchat', function ($user) {
    // make sure user is logged in
    return $user;
});