<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Payment;

class PaymentConfirmed extends Notification implements ShouldQueue
{
    use Queueable;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $payment     = $this->payment;
        $reservation = $payment->reservation;
        $isCompleted = $payment->status === 'completed';

        $mail = (new MailMessage)
            ->subject($isCompleted ? '💳 Paiement confirmé - Marol Hair Braiding' : '⏳ Paiement en attente - Marol Hair Braiding')
            ->greeting(($isCompleted ? 'Félicitations ' : 'Bonjour ') . $notifiable->name . ' !')
            ->line($isCompleted ? 'Votre paiement a été confirmé avec succès.' : 'Votre paiement est en attente de validation.')
            ->line('💰 Montant : $' . number_format($payment->amount, 2))
            ->line('📅 Date : ' . $payment->created_at->format('d/m/Y H:i'));

        if ($reservation) {
            $mail->line('🎯 Réservation : ' . ($reservation->service->name ?? '') . ' le ' . \Carbon\Carbon::parse($reservation->date)->format('d/m/Y'));
        }

        return $mail->action('Voir mes paiements', route('client.payments'))
            ->line('Merci pour votre confiance !')
            ->salutation('L\'équipe Marol Hair Braiding');
    }

    public function toArray(object $notifiable): array
    {
        $payment     = $this->payment;
        $isCompleted = $payment->status === 'completed';
        return [
            'icon'    => $isCompleted ? 'fa-solid fa-circle-check' : 'fa-regular fa-clock',
            'color'   => $isCompleted ? '#4ade80' : '#facc15',
            'title'   => $isCompleted ? 'Paiement confirmé' : 'Paiement en attente',
            'message' => 'Paiement de $' . number_format($payment->amount, 2) . ' ' . ($isCompleted ? 'confirmé.' : 'en attente de validation.'),
            'link'    => route('client.payments'),
        ];
    }
}
