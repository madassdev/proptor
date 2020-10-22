<?php

namespace App\Providers;

use App\Events\SalePaymentSuccess;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        \App\Events\PaymentSuccess::class => [
            \App\Listeners\SendPaymentApprovedNotification::class,
            \App\Listeners\UpdateSaleRecord::class,

        ],

        \App\Events\PaymentMade::class => [
            \App\Listeners\SendPaymentMadeNotification::class,
        ],

        \App\Events\AdminCreatedUser::class => [
            \App\Listeners\SendUserWelcomeNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
