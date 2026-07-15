<?php

namespace App\Services;

use App\Models\{Reservation, NotificationLog};
use Illuminate\Support\Facades\{Http, Log};

class NotificationService
{
    /**
     * Envoyer une confirmation de réservation
     */
    public static function sendConfirmation(Reservation $reservation): void
    {
        $message = self::buildMessage('confirmation', $reservation);
        self::send($reservation->client, $reservation, $message);
    }

    /**
     * Rappel 24h avant le rendez-vous
     */
    public static function sendReminder(Reservation $reservation): void
    {
        $message = self::buildMessage('reminder', $reservation);
        self::send($reservation->client, $reservation, $message);
    }

    /**
     * Notification d'annulation
     */
    public static function sendCancellation(Reservation $reservation): void
    {
        $message = self::buildMessage('cancellation', $reservation);
        self::send($reservation->client, $reservation, $message);
    }

    /**
     * Construire le message selon le type
     */
    private static function buildMessage(string $type, Reservation $reservation): string
    {
        $client  = $reservation->client->name;
        $service = $reservation->service->name;
        $date    = \Carbon\Carbon::parse($reservation->date)->locale('fr')->isoFormat('dddd D MMMM');
        $time    = \Carbon\Carbon::parse($reservation->start_time)->format('H:i');
        $emp     = $reservation->employee->user->name;
        $amount  = number_format($reservation->amount, 0, ',', ' ');
        $ref     = $reservation->reference;

        return match($type) {
            'confirmation' => "✅ *Réservation confirmée !*\n\nBonjour {$client},\n\nVotre rendez-vous est confirmé :\n📌 Prestation : {$service}\n👩‍💼 Coiffeuse : {$emp}\n📅 Date : {$date} à {$time}\n💰 Montant : {$amount}\n🔖 Réf : {$ref}\n\nNous vous attendons ! 💆‍♀️\n\n— GlamSalon Abidjan\n📞 +225 07 00 00 00",

            'reminder'     => "⏰ *Rappel rendez-vous !*\n\nBonjour {$client},\n\nVotre rendez-vous est demain :\n📌 {$service} avec {$emp}\n🕐 À {$time}\n\nN'oubliez pas ! 💅\n\n— GlamSalon Abidjan",

            'cancellation' => "❌ *Réservation annulée*\n\nBonjour {$client},\n\nVotre rendez-vous du {$date} à {$time} ({$service}) a été annulé.\n\nPour tout renseignement : +225 07 00 00 00\n\n— GlamSalon Abidjan",

            default => '',
        };
    }

    /**
     * Envoyer via WhatsApp (Twilio) ou SMS
     */
    private static function send($user, Reservation $reservation, string $message): void
    {
        $phone = $user->phone;
        if (!$phone) return;

        // Formater le numéro ivoirien
        $phone = preg_replace('/\s+/', '', $phone);
        if (!str_starts_with($phone, '+')) {
            $phone = '+225' . ltrim($phone, '0');
        }

        try {
            // Twilio WhatsApp
            $client = new \Twilio\Rest\Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );

            $client->messages->create(
                "whatsapp:{$phone}",
                [
                    'from' => config('services.twilio.whatsapp_from'),
                    'body' => $message,
                ]
            );

            // Logger
            \App\Models\NotificationLog::create([
                'user_id'        => $user->id,
                'reservation_id' => $reservation->id,
                'type'           => 'whatsapp',
                'subject'        => 'Notification réservation',
                'message'        => $message,
                'status'         => 'sent',
                'sent_at'        => now(),
            ]);

        } catch (\Exception $e) {
            Log::error('WhatsApp notification failed', [
                'error'   => $e->getMessage(),
                'user_id' => $user->id,
                'phone'   => $phone,
            ]);

            // Essayer SMS comme fallback
            self::sendSms($user, $reservation, $message);
        }
    }

    private static function sendSms($user, $reservation, string $message): void
    {
        try {
            $client = new \Twilio\Rest\Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );

            $phone = preg_replace('/\s+/', '', $user->phone);
            if (!str_starts_with($phone, '+')) {
                $phone = '+225' . ltrim($phone, '0');
            }

            $client->messages->create($phone, [
                'from' => config('services.twilio.from'),
                'body' => strip_tags(str_replace('*', '', $message)),
            ]);

        } catch (\Exception $e) {
            Log::error('SMS notification failed', ['error' => $e->getMessage()]);
        }
    }
}
