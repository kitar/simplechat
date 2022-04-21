<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index($roomId, $messageId = null)
    {
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
        $payload = $this->validate($request, [
            'room_id' => 'required',
            'message' => 'required',
        ]);

        $payload['username'] = 'kitar';

        Message::create($payload);
    }
}
