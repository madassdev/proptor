<?php

namespace App\Listeners;

use App\Events\PaymentMade;
use App\Events\PaymentSuccess;
use App\Models\User;
use App\Notifications\PendingPaymentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendPaymentMadeNotification
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
     * @param  PaymentMade  $event
     * @return void
     */
    public function handle(PaymentMade $event)
    {
        $admins = User::role('admin')->get();
        Notification::send($admins, new PendingPaymentNotification($event->payment));

    }
}
