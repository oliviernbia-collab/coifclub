<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class ReservationReminder24h extends Notification implements ShouldQueue
{
    use Queueable;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $reservation = $this->reservation;
        $service     = $reservation->service;
        $employee    = $reservation->employee;

        return (new MailMessage)
            ->subject('⏰ Rappel : Votre rendez-vous demain - Marol Hair Braiding')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Rappel automatique pour votre rendez-vous de demain.')
            ->line('📅 Date : ' . \Carbon\Carbon::parse($reservation->date)->format('d/m/Y'))
            ->line('⏰ Heure : ' . $reservation->start_time)
            ->line('💇‍♀️ Service : ' . ($service->name ?? ''))
            ->line('👩‍💼 Coiffeuse : ' . ($employee->name ?? ''))
            ->action('Voir les détails', route('client.reservations'))
            ->line('N\'oubliez pas d\'arriver 10 minutes en avance.')
            ->salutation('L\'équipe Marol Hair Braiding');
    }

    public function toArray(object $notifiable): array
    {
        $reservation = $this->reservation;
        return [
            'icon'    => 'fa-regular fa-bell',
            'color'   => '#facc15',
            'title'   => 'Rappel — rendez-vous demain',
            'message' => 'Votre rendez-vous est demain à ' . $reservation->start_time . ' — ' . ($reservation->service->name ?? 'Service') . '.',
            'link'    => route('client.reservations'),
        ];
    }
}
