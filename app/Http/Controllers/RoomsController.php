<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
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

    public function store(Request $request): RedirectResponse
    {
        $payload = $this->validate($request, [
            'name' => ['required', 'max:50', function ($attribute, $value, $fail) use ($request) {
                if ($request->user() && Room::getUserRooms($request->user()->uuid)['rooms']->count() >= 10) {
                    $fail('You cannot create rooms more than 10.');
                }
            }],
            'password' => ['nullable', 'max:50'],
        ]);

        if (! empty($payload['password'])) {
            $payload['password'] = Hash::make($payload['password']);
        }

        $payload['owner_session_id'] = session()->getId();
        if ($request->user()) {
            $payload['created_by'] = $request->user()->uuid;
        }

        $room = Room::create($payload);

        if ($request->user()) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('rooms.show', $room->id);
        }
    }

    public function enter(Request $request, Room $room): RedirectResponse
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

    public function show(Request $request, Room $room): View
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

    public function leave(Request $request, Room $room): RedirectResponse
    {
        session()->forget("rooms.{$room->id}");

        return redirect()->route('rooms.show', $room->id);
    }

    public function edit(Request $request, Room $room): View
    {
        $this->authorize('manage-room', $room);

        return view('rooms.edit', [
            'room' => $room,
        ]);
    }

    public function update(Request $request, Room $room): RedirectResponse
    {
        $this->authorize('manage-room', $room);

        $payload = $this->validate($request, [
            'name' => ['required', 'min:2', 'max:50'],
        ]);

        $room->update($payload);

        return redirect()->route('dashboard');
    }

    public function destroy(Request $request, Room $room): RedirectResponse
    {
        $this->authorize('manage-room', $room);

        $room->delete();

        return redirect()->route('dashboard');
    }
}
