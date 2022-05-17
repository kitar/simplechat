<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UserDelete extends Command
{
    protected $signature = 'user:delete {uuid} {--with-data}';

    protected $description = 'Delete a user.';

    public function handle()
    {
        $uuid = $this->argument('uuid');
        $user = User::findByUuid($uuid);
        if (! $user) {
            return;
        }

        if ($this->option('with-data')) {
            // todo
        }

        $user->delete();
        $this->info("USER#{$uuid} deleted.");
    }
}
