<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index($roomId, $messageId = null)
    {
        $this->authorize('show-room', $roomId);

        $exclusiveStartKey = null;
        if ($messageId) {
            $exclusiveStartKey = [
                'PK' => ['S' => "ROOM#{$roomId}"],
                'SK' => ['S' => "MSG#{$messageId}"],
            ];
        }

        return Message::getMessages($roomId, $exclusiveStartKey)['messages'];
    }

    public function store(Request $request)
    {
        $this->authorize('show-room', $request->room_id);

        $payload = $this->validate($request, [
            'room_id' => ['required'],
            'message' => ['required', 'min:1', 'max:1000'],
        ]);

        $payload['username'] = session()->get("rooms.{$request->room_id}.username");
        $payload['owner_session_id'] = session()->getId();
        if ($request->user()) {
            $payload['created_by'] = $request->user()->uuid;
        }

        Message::create($payload);
    }

    public function destroy(Request $request, $roomId, $messageId)
    {
        $message = Message::find($messageId);

        $this->authorize('manage-message', $message);

        $message->delete();
    }
}
