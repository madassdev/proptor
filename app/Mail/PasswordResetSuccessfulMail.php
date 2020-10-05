<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\HtmlString;

class PasswordResetSuccessfulMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $generated_password;
    public function __construct(User $user, String $generated_password)
    {
        $this->user = $user;
        $this->generated_password = $generated_password;
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
        return $this->view('email.auth.password-reset-success');
    }
}
