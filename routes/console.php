<?php
// routes/console.php — Tâches planifiées
// ═══════════════════════════════════════════════════
// Ajouter dans bootstrap/app.php :
//
// ->withSchedule(function (Schedule $schedule) {
//     // Rappels WhatsApp chaque jour à 9h
//     $schedule->command('salon:remind')->dailyAt('09:00');
//
//     // Nettoyage des réservations expirées (non payées après 30 min)
//     $schedule->command('salon:cleanup')->everyThirtyMinutes();
// })

use Illuminate\Support\Facades\Schedule;

// Rappels quotidiens à 9h du matin
Schedule::command('salon:remind')->dailyAt('09:00');

// Envoi des rappels de réservation toutes les heures
Schedule::job(new \App\Jobs\SendReservationReminders)->hourly();

// ═══════════════════════════════════════════════════
// CONFIGURATION .env COMPLÈTE
// ═══════════════════════════════════════════════════
/*
APP_NAME="GlamSalon"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://glamsalon.ci

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=glamsalon
DB_USERNAME=root
DB_PASSWORD=

# Paiement CinetPay (Orange Money / MTN / Wave)
CINETPAY_URL=https://api-checkout.cinetpay.com/v2
CINETPAY_KEY=
CINETPAY_SITE_ID=

# Stripe
STRIPE_KEY=
STRIPE_SECRET=

# Twilio (WhatsApp + SMS)
TWILIO_SID=
TWILIO_TOKEN=
TWILIO_FROM=+1234567890
TWILIO_WHATSAPP_FROM=whatsapp:+14155238886

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=contact@glamsalon.ci
MAIL_PASSWORD=
MAIL_FROM_ADDRESS="contact@glamsalon.ci"
MAIL_FROM_NAME="GlamSalon"
*/
