<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $rooms = Room::getUserRooms($request->user()->uuid);

        return view('dashboard', [
            'rooms' => $rooms['rooms'],
            'LastEvaluatedKey' => $rooms['LastEvaluatedKey'],
        ]);
    }
}
