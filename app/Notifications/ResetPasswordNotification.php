<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
{
    $url = url(route('password.reset', $this->token, false));

    return (new \Illuminate\Notifications\Messages\MailMessage)
        ->view('emails.password', ['url' => $url]);
}

}
