<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
class AdMessage extends Notification
{
    use Queueable;
    protected $ad;
    protected $message;
    protected $email;
    public function __construct($ad, $message, $email)
    {
        $this->ad = $ad;
        $this->message = $message;
        $this->email = $email;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Vous avez reçu un message concernant une annonce que vous avez déposée :')
                    ->line('--------------------------------------')
                    ->line($this->message)
                    ->line('--------------------------------------')
                    ->action('Voir votre annonce', route('annonces.show', $this->ad->id))
                    ->line("L'email de l'expéditeur est : " . $this->email)
                    ->line("Merci d'utiliser notre site pour vos annonces !");
    }
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}