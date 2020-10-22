<?php

namespace App\Listeners;

use App\Events\AdminCreatedUser;
use App\Notifications\User\UserWelcomeNotificaton;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendUserWelcomeNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdminCreatedUser  $event
     * @return void
     */
    public function handle(AdminCreatedUser $event)
    {
        Notification::send($event->user, new UserWelcomeNotificaton($event->user));
    }
}
