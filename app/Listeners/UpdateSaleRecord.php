<?php

namespace App\Listeners;

use App\Events\PaymentSuccess;
use App\Notifications\PaymentSuccessfulNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateSaleRecord
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
        $payment =  $event->payment;
        $payment->sale->total_paid += $payment->amount;
        $payment->sale->save(); 
    }
}
