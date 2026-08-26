<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;

class UpdateLastLogin
{
    /**
     * Create the event listener.
     */
    public function __construct(protected Request $request)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        
        $user->last_login_at = now();
        $user->last_login_ip = $this->request->ip();
        
        // Prevent touching timestamps if not needed, but here it's fine.
        $user->save();
    }
}
