<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailVerifyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return [
            'mail',
        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Hey!')
            ->line('Thanks for checking out MVM.')
            ->action('Verify Your Email', url("verify?token={$notifiable->email_verify_token}"))
            ->line('Find a route and go fast!');
    }
}
