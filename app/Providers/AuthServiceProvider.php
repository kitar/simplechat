<?php

namespace App\Providers;

use App\Models\Message;
use App\Models\Room;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Kitar\Dynamodb\Model\AuthUserProvider;

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

        Auth::provider('dynamodb', function ($app, array $config) {
            return new AuthUserProvider(
                $app['hash'],
                $config['model'],
                $config['api_token_name'] ?? null,
                $config['api_token_index'] ?? null
            );
        });

        Gate::define('show-room', function (?User $user, $roomId) {
            $roomSession = session()->get("rooms.{$roomId}");
            if (
                ! empty($roomId) &&
                ! empty($roomSession) &&
                ! empty($roomSession['username'])
            ) {
                return true;
            }
        });

        Gate::define('manage-room', function (User $user, Room $room) {
            return $user->uuid === $room->created_by;
        });

        Gate::define('manage-message', function (?User $user, Message $message) {
            return $message && $message->owner_session_id == session()->getId();
        });
    }
}
