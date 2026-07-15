<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Reservation;

class NewReservationAdmin extends Notification implements ShouldQueue
{
    use Queueable;

    public $reservation;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $reservation = $this->reservation;
        $date = $reservation->date instanceof \Carbon\Carbon
            ? $reservation->date->format('d/m/Y')
            : \Carbon\Carbon::parse($reservation->date)->format('d/m/Y');
        $client = $reservation->client->name ?? 'Client';
        $service = $reservation->service->name ?? 'Service';

        return [
            'icon'    => 'fa-solid fa-calendar-plus',
            'color'   => '#a78bfa',
            'title'   => 'Nouvelle réservation',
            'message' => $client . ' — ' . $service . ' le ' . $date . ' à ' . $reservation->start_time . '.',
            'link'    => route('admin.reservations'),
        ];
    }
}
