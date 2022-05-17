<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class RoomsController extends Controller
{
    public function index(Request $request)
    {
        $roomsHistory = collect($request->session()->get('roomsHistory'))->sortByDesc(function ($item) {
            return $item['joined_at'];
        });

        return view('rooms.index', ['roomsHistory' => $roomsHistory]);
    }

    public function store(Request $request)
    {
        $payload = $this->validate($request, [
            'name' => ['required', 'max:50'],
            'password' => ['nullable', 'max:50'],
        ]);

        if (! empty($payload['password'])) {
            $payload['password'] = Hash::make($payload['password']);
        }

        $payload['owner_session_id'] = session()->getId();

        $room = Room::create($payload);

        return redirect()->route('rooms.show', $room->id);
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
        session()->put("roomsHistory.{$room->id}", [
            'name' => $room->name,
            'joined_at' => now()->format('Y-m-d H:i'),
        ]);

        return redirect()->route('rooms.show', $room->id);
    }

    public function show(Request $request, Room $room)
    {
        if (Gate::denies('show-room', $room->id)) {
            return view('rooms.entrance', [
                'room' => $room,
            ]);
        }

        return view('rooms.show', [
            'room' => $room,
            'username' => session()->get("rooms.{$room->id}.username"),
        ]);
    }

    public function leave(Request $request, Room $room)
    {
        session()->forget("rooms.{$room->id}");

        return redirect()->route('rooms.show', $room->id);
    }
}
