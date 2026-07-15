<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class ReservationReminder2h extends Notification implements ShouldQueue
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
            ->subject('🚨 Rappel urgent : votre rendez-vous dans 2h - Marol Hair Braiding')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Votre rendez-vous approche !')
            ->line('📅 Date : ' . \Carbon\Carbon::parse($reservation->date)->format('d/m/Y'))
            ->line('⏰ Heure : ' . $reservation->start_time)
            ->line('💇‍♀️ Service : ' . ($service->name ?? ''))
            ->line('👩‍💼 Coiffeuse : ' . ($employee->name ?? ''))
            ->action('Voir les détails', route('client.reservations'))
            ->line('Merci d\'arriver 10 minutes en avance.')
            ->salutation('L\'équipe Marol Hair Braiding');
    }

    public function toArray(object $notifiable): array
    {
        $reservation = $this->reservation;
        return [
            'icon'    => 'fa-solid fa-bell',
            'color'   => '#fb923c',
            'title'   => 'Rendez-vous dans 2 heures',
            'message' => 'Votre rendez-vous est dans 2h à ' . $reservation->start_time . ' — ' . ($reservation->service->name ?? 'Service') . '.',
            'link'    => route('client.reservations'),
        ];
    }
}
