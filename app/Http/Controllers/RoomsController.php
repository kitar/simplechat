<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    public function show(Request $request, $roomId)
    {
        $room = Room::find($roomId);
        if (empty($room)) {
            abort(404);
        }

        return view('rooms.show', [
            'room' => $room,
        ]);
    }
}
