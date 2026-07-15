<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoyaltyPointsAwarded extends Notification implements ShouldQueue
{
    use Queueable;

    public int $points;
    public string $reason;
    public int $newBalance;

    public function __construct(int $points, string $reason, int $newBalance)
    {
        $this->points     = $points;
        $this->reason     = $reason;
        $this->newBalance = $newBalance;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('+ ' . $this->points . ' points fidélité ajoutés - Marol Hair Braiding')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Bonne nouvelle ! Votre compte fidélité vient d\'être crédité.')
            ->line('**+' . $this->points . ' points** ont été ajoutés pour : *' . $this->reason . '*')
            ->line('Votre solde actuel : **' . number_format($this->newBalance) . ' points**')
            ->action('Voir mon solde fidélité', route('client.loyalty'))
            ->line('Merci pour votre fidélité !')
            ->salutation('L\'équipe Marol Hair Braiding');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'icon'    => 'fa-solid fa-star',
            'color'   => '#facc15',
            'title'   => '+' . $this->points . ' points fidélité',
            'message' => $this->reason . '. Solde : ' . number_format($this->newBalance) . ' pts.',
            'link'    => route('client.loyalty'),
        ];
    }
}
