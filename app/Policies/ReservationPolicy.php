<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;

class ReservationPolicy
{
    public function view(User $user, Reservation $reservation): bool
    {
        return $user->role === 'admin'
            || $user->role === 'employee'
            || $reservation->client_id === $user->id;
    }

    public function update(User $user, Reservation $reservation): bool
    {
        return $user->role === 'admin'
            || $user->role === 'employee'
            || $reservation->client_id === $user->id;
    }

    public function delete(User $user, Reservation $reservation): bool
    {
        return $user->role === 'admin'
            || $reservation->client_id === $user->id;
    }

    public function cancel(User $user, Reservation $reservation): bool
    {
        return $user->role === 'admin'
            || $reservation->client_id === $user->id;
    }
}
