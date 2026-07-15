<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class ReservationConfirmed extends Notification implements ShouldQueue
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
            ->subject('🎉 Votre rendez-vous est confirmé - Marol Hair Braiding')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Votre rendez-vous chez Marol Hair Braiding a été confirmé avec succès.')
            ->line('📅 Date : ' . \Carbon\Carbon::parse($reservation->date)->format('d/m/Y'))
            ->line('⏰ Heure : ' . $reservation->start_time)
            ->line('💇‍♀️ Service : ' . ($service->name ?? ''))
            ->line('👩‍💼 Coiffeuse : ' . ($employee->name ?? ''))
            ->line('💰 Prix : $' . number_format($reservation->amount, 2))
            ->action('Voir mes réservations', route('client.reservations'))
            ->line('Nous vous attendons avec impatience !')
            ->salutation('L\'équipe Marol Hair Braiding');
    }

    public function toArray(object $notifiable): array
    {
        $reservation = $this->reservation;
        $date = $reservation->date instanceof \Carbon\Carbon
            ? $reservation->date->format('d/m/Y')
            : \Carbon\Carbon::parse($reservation->date)->format('d/m/Y');
        return [
            'icon'    => 'fa-solid fa-calendar-check',
            'color'   => '#4ade80',
            'title'   => 'Rendez-vous confirmé',
            'message' => 'Votre rendez-vous du ' . $date . ' à ' . $reservation->start_time . ' est confirmé.',
            'link'    => route('client.reservations'),
        ];
    }
}
