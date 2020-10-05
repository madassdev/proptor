<?php

namespace App\Mail;

use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\HtmlString;

class PasswordResetTokenMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $password_reset_url;
    public $user;
    public $token;
    
    public function __construct(User $user, $password_reset_url, $token)
    {
        $this->user = $user;
        $this->password_reset_url = $password_reset_url;
        $this->token = $token;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $message = (new MailMessage)
            ->line('We received a request for your password reset')
            ->line('Here is your reset token:')
            ->line(new HtmlString(
                "<strong style='font-size:25px; font-weight:bold; color:#ff8000'>".$this->token."</strong>"
            ))
            ;

        return $this->markdown('vendor.notifications.email', $message->data());

        return (new MailMessage)
        ->subject('Payment was received via ')
        ->line('A payment has been made')
        // ->action('View payment', route('mailroutes.admin.payments.show', ['payment'=>$this->payment->id]))
        ;
    }
}
