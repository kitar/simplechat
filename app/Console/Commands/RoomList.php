<?php

namespace App\Console\Commands;

use App\Models\Room;
use Illuminate\Console\Command;

class RoomList extends Command
{
    protected $signature = 'room:list {--user=}';

    protected $description = 'List rooms.';

    public function handle()
    {
        $options = $this->options();

        if ($options['user']) {
            $rooms = Room::getUserRooms($options['user']);
        } else {
            $rooms = Room::getAllRooms();
        }

        $schema = ['id', 'name', 'created_by', 'created_at'];
        $this->table($schema, $rooms['rooms']->map(function ($item) use ($schema) {
            return $item->only($schema);
        }));
        $this->info("LastEvaluatedKey: {$rooms['LastEvaluatedKey']}");
    }
}
