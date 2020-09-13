<?php

namespace App\Mail;

use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

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
    
    public function __construct(User $user, $password_reset_url)
    {
        $this->user = $user;
        $this->password_reset_url = $password_reset_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.auth.reset-token');
    }
}
