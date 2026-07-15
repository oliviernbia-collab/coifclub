<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReservationStatusChanged extends Notification
{
    use Queueable;

    public $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        $reservation = $this->reservation;
        $statusLabels = [
            'confirmed' => 'confirmée',
            'cancelled' => 'annulée',
            'completed' => 'terminée',
            'pending'   => 'en attente',
        ];
        $statusLabel = $statusLabels[$reservation->status] ?? $reservation->status;

        return (new MailMessage)
            ->subject('Mise à jour de votre réservation - Marol Hair Braiding')
            ->greeting('Bonjour ' . $notifiable->name . ' !')
            ->line('Votre réservation a été ' . $statusLabel . '.')
            ->action('Voir mes réservations', route('client.reservations'))
            ->salutation('L\'équipe Marol Hair Braiding');
    }

    public function toArray($notifiable): array
    {
        $reservation = $this->reservation;
        $date = $reservation->date instanceof \Carbon\Carbon
            ? $reservation->date->format('d/m/Y')
            : \Carbon\Carbon::parse($reservation->date)->format('d/m/Y');

        $map = [
            'confirmed' => ['fa-solid fa-calendar-check', '#4ade80', 'Rendez-vous confirmé'],
            'cancelled' => ['fa-solid fa-calendar-xmark', '#f87171', 'Rendez-vous annulé'],
            'completed' => ['fa-solid fa-circle-check',   '#60a5fa', 'Rendez-vous terminé'],
            'pending'   => ['fa-regular fa-clock',        '#facc15', 'Rendez-vous en attente'],
        ];
        [$icon, $color, $title] = $map[$reservation->status] ?? $map['pending'];

        return [
            'icon'    => $icon,
            'color'   => $color,
            'title'   => $title,
            'message' => 'Votre réservation du ' . $date . ' a été mise à jour.',
            'link'    => route('client.reservations'),
        ];
    }
}
