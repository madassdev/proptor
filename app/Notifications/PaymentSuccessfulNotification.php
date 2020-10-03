<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class PaymentSuccessfulNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $payment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Payment successful.')
                    ->greeting('Thank you!')
                    ->line(new HtmlString('Your payment of NGN<strong>'.number_format($this->payment->amount).'</strong> was successful'))
                    ->line(new HtmlString('The payment was for <strong>'.strtoupper($this->payment->sale->property->name).'</strong>'))
                    ->line(new HtmlString('Total paid is NGN<strong>'.number_format($this->payment->sale->total_paid).'</strong>'))
                    ->line(new HtmlString('Total remaining payment is NGN<strong>'.number_format($this->payment->sale->total_amount - $this->payment->sale->total_paid) .'</strong> of NGN<strong>'.number_format($this->payment->sale->total_amount).'</strong>'))
                    // ->action('Notification Action', url('/'))
                    ;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
