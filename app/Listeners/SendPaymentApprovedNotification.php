<?php

namespace App\Listeners;

use App\Events\PaymentSuccess;
use App\Models\User;
use App\Notifications\AdminPaymentSuccessfulNotification;
use App\Notifications\PaymentSuccessfulNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendPaymentApprovedNotification
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
     * @param  PaymentSuccess  $event
     * @return void
     */
    public function handle(PaymentSuccess $event)
    {
        if($event->payment->status != 'autopaid')
        {
            $admins = User::role('admin')->get();
            Notification::send($admins, new AdminPaymentSuccessfulNotification($event->payment));
        }
        
        Notification::send($event->payment->user, new PaymentSuccessfulNotification($event->payment));
    }
}
