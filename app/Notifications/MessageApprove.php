<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\ { Ad, Message };
class MessageApprove extends Notification
{
    use Queueable;
    protected $ad;
    protected $message;
    public function __construct(Ad $ad, Message $message)
    {
        $this->ad = $ad;
        $this->message = $message;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }
    public function toMail($notifiable)
    {
        return (new MailMessage)
                ->line('Nous avons approuvé ce message que vous avez déposé pour une annonce :')
                ->line('--------------------------------------')
                ->line($this->message->texte)
                ->line('--------------------------------------')
                ->action('Voir cette annonce', route('annonces.show', $this->ad->id))
                ->line("Merci d'utiliser notre site !");
    }
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}