<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class PendingPaymentNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $payment;
    public $url;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
        $this->url = config('app.url').'/admin/payments/'.$this->payment->id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
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
                    ->line('A payment has been made')
                    ->line(new HtmlString(ucfirst($this->payment->user->full_name).' has made a payment of <strong>'.config('payment.naira').$this->payment->amount.'</strong>'))
                    ->line('Please visit the dashboard to Confirm or Cancel')
                    ->action('View payment', $this->url)
                    ->line('Thank you for using our application!');
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
            "message" => "Confirm manual deposit of ".config('payment.naira').number_format($this->payment->amount),
            "icon" => "<i class='cil-credit-card text-warning mfe-2' style='border-radius:20px'></i>",
            "redirect_url" =>$this->url,
        ];
    }
}
