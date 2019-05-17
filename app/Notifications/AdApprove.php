<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Ad;

class AdApprove extends Notification
{
    use Queueable;
    protected $ad;

    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Nous avons approuvé une annonce que vous avez déposée :')
                    ->action('Voir votre annonce', route('annonces.show', $this->ad->id))
                    ->line("Merci d'utiliser notre site pour vos annonces !");
    }
    
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}