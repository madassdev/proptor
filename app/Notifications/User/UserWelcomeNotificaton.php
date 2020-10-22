<?php

namespace App\Notifications\User;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserWelcomeNotificaton extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $user;
    Public $url;

    public function __construct(User $user)
    {
        // $this->url = config('app.url').'/admin/payments/';
        $this->user = $user;
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
                    ->subject('Welcome Onboard.')
                    ->greeting('Thank You!')
                    ->line('We are glad to welcome you onboard.')
                    ->line('You can now login to your dashboard with this email and the password below')
                    ->line(new HtmlString('<strong style="text-align:center;font-size:25px;color:#ff8000">'.$this->user->v_code.'</strong>'))
                    // ->action('View payment', $this->url)
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
            //
        ];
    }
}
