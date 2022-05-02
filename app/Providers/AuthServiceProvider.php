<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('show-room', function (?User $user, $roomId) {
            $roomSession = session()->get("rooms.{$roomId}");
            if (
                ! empty($roomId) &&
                ! empty($roomSession) &&
                ! empty($roomSession['username'])
            ) {
                return true;
            }

            // todo: allow if $user owned the room.
        });

        Gate::define('manage-message', function (?User $user, Message $message) {
            return $message && $message->owner_session_id == session()->getId();
        });
    }
}
