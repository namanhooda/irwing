<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class SetDefaultRoleOnLogin
{
    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;

        // Store first assigned role as default active role
        session(['active_role' => $user->getRoleNames()->first()]);
    }
}
