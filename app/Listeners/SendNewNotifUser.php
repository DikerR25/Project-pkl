<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\RegistrationSuccesful;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendNewNotifUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event)
    {
        $admins = User::where('akses', 'admin')->get();
        Notification::send($admins, new RegistrationSuccesful($event->user));
    }
}
