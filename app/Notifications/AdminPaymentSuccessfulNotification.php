<?php

namespace App\Notifications;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class AdminPaymentSuccessfulNotification extends Notification implements ShouldQueue
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
        return $this->payment->method == 'bank-transfer' ? ['database'] :['database', 'mail'];
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
                    ->subject('Payment was received via ' .strtoupper($this->payment->method))
                    ->line('A payment has been made')
                    ->line(new HtmlString(ucfirst($this->payment->user->full_name).' has made a payment of  NGN<strong>'.number_format($this->payment->amount) .'</strong> via <strong>'. ucfirst($this->payment->method).'</strong>'))
                    ->line(new HtmlString('The payment was for <strong>'.ucfirst($this->payment->sale->property->name).'</strong>'))
                    // ->action('View payment', route('mailroutes.admin.payments.show', ['payment'=>$this->payment->id]))
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
        return $this->payment->method == 'bank-transfer' ? 
        [
            "message" => "Payment marked as complete",
            "icon" => "<i class='cil-check text-success mfe-2' style='border-radius:20px'></i>",
            "redirect_url" =>$this->url,
        ]
        :
        [
            "message" => "User paid ".config('payment.naira').number_format($this->payment->amount),
            "icon" => "<i class='cil-dollar text-success border-success mfe-2' style='border-radius:20px'></i>",
            "redirect_url" =>$this->url,
        ];
    }

}
