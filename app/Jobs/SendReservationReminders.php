<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\Reservation;
use App\Notifications\ReservationReminder24h;
use App\Notifications\ReservationReminder2h;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendReservationReminders implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Starting reservation reminders job');

        $this->send24HourReminders();
        $this->send2HourReminders();

        Log::info('Reservation reminders job completed');
    }

    /**
     * Send reminders for reservations 24 hours from now
     */
    private function send24HourReminders()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $reservations = Reservation::where('date', $tomorrow)
            ->where('status', 'confirmed')
            ->whereDoesntHave('notifications', function ($query) {
                $query->where('type', 'reservation_reminder_24h');
            })
            ->with(['client', 'service', 'employee'])
            ->get();

        Log::info("Found {$reservations->count()} reservations for 24h reminders");

        foreach ($reservations as $reservation) {
            try {
                $reservation->client->notify(new ReservationReminder24h($reservation));
                Log::info("Sent 24h reminder for reservation {$reservation->id}");
            } catch (\Exception $e) {
                Log::error("Failed to send 24h reminder for reservation {$reservation->id}: " . $e->getMessage());
            }
        }
    }

    /**
     * Send reminders for reservations 2 hours from now
     */
    private function send2HourReminders()
    {
        $twoHoursFromNow = Carbon::now()->addHours(2);
        $today = Carbon::today()->toDateString();

        $reservations = Reservation::where('date', $today)
            ->where('status', 'confirmed')
            ->whereRaw("TIME(time) BETWEEN ? AND ?", [
                $twoHoursFromNow->copy()->subMinutes(30)->format('H:i:s'),
                $twoHoursFromNow->copy()->addMinutes(30)->format('H:i:s')
            ])
            ->whereDoesntHave('notifications', function ($query) {
                $query->where('type', 'reservation_reminder_2h');
            })
            ->with(['client', 'service', 'employee'])
            ->get();

        Log::info("Found {$reservations->count()} reservations for 2h reminders");

        foreach ($reservations as $reservation) {
            try {
                $reservation->client->notify(new ReservationReminder2h($reservation));
                Log::info("Sent 2h reminder for reservation {$reservation->id}");
            } catch (\Exception $e) {
                Log::error("Failed to send 2h reminder for reservation {$reservation->id}: " . $e->getMessage());
            }
        }
    }
}
