<?php

namespace App\Console\Commands;

use App\Models\Message;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MessageList extends Command
{
    protected $signature = 'message:list {--room=} {--user=}';

    protected $description = 'List messages.';

    public function handle()
    {
        $options = $this->options();

        if ($options['room']) {
            $messages = Message::getMessages($options['room']);
        } elseif ($options['user']) {
            $messages = Message::getUserMessages($options['user']);
        } else {
            $messages = Message::getAllMessages();
        }

        $schema = ['id', 'room_id', 'username', 'message', 'created_by', 'created_at'];
        $this->table($schema, $messages['messages']->map(function ($item) use ($schema) {
            $item = $item->only($schema);
            $item['username'] = Str::limit($item['username'], 20);
            $item['message'] = Str::limit($item['message'], 20);

            return $item;
        }));
        $this->info("LastEvaluatedKey: {$messages['LastEvaluatedKey']}");
    }
}
