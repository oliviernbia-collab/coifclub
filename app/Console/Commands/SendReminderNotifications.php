<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Services\NotificationService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class SendReminderNotifications extends Command
{
    protected $signature   = 'salon:remind';
    protected $description = 'Envoie des rappels WhatsApp aux clientes ayant un RDV demain';

    public function handle(): void
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $reservations = Reservation::with(['client', 'service', 'employee.user'])
            ->where('date', $tomorrow)
            ->where('status', 'confirmed')
            ->whereHas('client', fn($q) => $q->whereNotNull('phone'))
            ->get();

        $this->info("📅 {$reservations->count()} réservation(s) demain ({$tomorrow}).");

        foreach ($reservations as $reservation) {
            NotificationService::sendReminder($reservation);
            $this->line("  ✓ Rappel envoyé à {$reservation->client->name}");
        }

        $this->info('✅ Rappels envoyés avec succès.');
    }
}
