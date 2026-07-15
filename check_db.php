<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Reservation;
use App\Models\Payment;

echo "=== RESERVATIONS ===\n";
$reservations = Reservation::all();
foreach($reservations as $r) {
    echo "ID: {$r->id}, Status: {$r->status}, Client: {$r->client_id}, Amount: {$r->amount}\n";
}

echo "\n=== PAYMENTS ===\n";
$payments = Payment::all();
foreach($payments as $p) {
    echo "ID: {$p->id}, Reservation: {$p->reservation_id}, Method: {$p->method}, Status: {$p->status}, Amount: {$p->amount}\n";
}