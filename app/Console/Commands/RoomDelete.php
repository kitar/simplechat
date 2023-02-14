<?php

namespace App\Console\Commands;

use App\Models\Room;
use Illuminate\Console\Command;

class RoomDelete extends Command
{
    protected $signature = 'room:delete {roomId}';

    protected $description = 'Delete a room.';

    public function handle(): void
    {
        $roomId = $this->argument('roomId');

        $room = Room::find($roomId);

        if ($room) {
            $room->delete();
            $this->info("ROOM#{$roomId} deleted.");
        }
    }
}
