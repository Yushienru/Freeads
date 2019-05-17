<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AdRefuse extends Notification
{
    use Queueable;
    protected $message;
    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Nous avons refusé une annonce que vous avez déposée pour la raison suivante :')
                    ->line($this->message)
                    ->line("Merci d'utiliser notre site pour vos annonces !");
    }
    
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}