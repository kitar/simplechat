<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Room;
use Illuminate\Http\Request;

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
