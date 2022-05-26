<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Uuid;

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

Broadcast::channel('rooms.{roomId}', function ($user, $roomId) {
    if (Gate::allows('show-room', $roomId)) {
        return [
            'id' => $user->id,
            'username' => session()->get("rooms.{$roomId}.username"),
        ];
    }
});

Route::post('broadcasting/auth', function () {
    $request = request()->setUserResolver(function () {
        return new User(['id' => Uuid::uuid4()->toString()]);
    });

    return Broadcast::auth($request);
})->middleware('web');
