<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class RoomsController extends Controller
{
    public function entrance(Request $request, Room $room)
    {
        if (Gate::allows('show-room', $room->id)) {
            return redirect()->route('rooms.show', $room->id);
        }

        return view('rooms.entrance', [
            'room' => $room,
        ]);
    }

    public function enter(Request $request, Room $room)
    {
        $this->validate($request, [
            'username' => ['required', 'min:2', 'max:50'],
            'password' => function ($attribute, $value, $fail) use ($room) {
                if (! empty($room->password) && ! Hash::check($value, $room->password)) {
                    $fail('The password is not correct.');
                }
            },
        ]);

        session()->put("rooms.{$room->id}.username", $request->username);

        return redirect()->route('rooms.show', $room->id);
    }

    public function show(Request $request, Room $room)
    {
        if (Gate::denies('show-room', $room->id)) {
            return redirect()->route('rooms.entrance', $room->id);
        }

        return view('rooms.show', [
            'room' => $room,
        ]);
    }

    public function leave(Request $request, Room $room)
    {
        session()->forget("rooms.{$room->id}");

        return redirect()->route('rooms.show', $room->id);
    }
}
