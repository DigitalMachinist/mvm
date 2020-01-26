<?php

namespace App\Notifications\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification implements ShouldQueue
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
            ->line('Need some help clipping back into the site?')
            ->action('Reset Your Password', url("password?token={$notifiable->password_reset_token}"))
            ->line('Find a route and go fast!');
    }
}
