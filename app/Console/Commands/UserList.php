<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UserList extends Command
{
    protected $signature = 'user:list';

    protected $description = 'List users.';

    public function handle(): void
    {
        $users = User::getUsers();

        $schema = ['email', 'name', 'uuid', 'created_at'];
        $this->table($schema, $users['users']->map(function ($item) use ($schema) {
            return $item->only($schema);
        }));
        $this->info("LastEvaluatedKey: {$users['LastEvaluatedKey']}");
    }
}
