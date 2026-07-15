@extends(auth()->check() && auth()->user()->role === 'client' ? 'layouts.client' : 'layouts.app')

@section('title', 'Rendez-vous enregistré')

@section('content')

<style>
.ac-wrap { max-width: 560px; margin: 60px auto; padding: 20px; text-align: center; }

.ac-icon {
    width: 80px; height: 80px; border-radius: 50%;
    background: linear-gradient(135deg, #e91e8c, #c91a78);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px;
    box-shadow: 0 10px 30px rgba(233,30,140,.4);
    font-size: 2rem; color: #fff;
}
.ac-title { font-size: 1.9rem; font-weight: 900; color: #fff; margin-bottom: 10px; }
.ac-sub { color: rgba(255,255,255,.55); font-size: .95rem; margin-bottom: 28px; }

.ac-card {
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(233,30,140,.15);
    border-radius: 24px; padding: 28px;
    margin-bottom: 20px;
    text-align: left;
}
.ac-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; }
.ac-row + .ac-row { border-top: 1px solid rgba(255,255,255,.06); }
.ac-lbl { font-size: .72rem; text-transform: uppercase; letter-spacing: .7px; color: rgba(255,255,255,.35); font-weight: 700; }
.ac-val { font-size: .92rem; font-weight: 700; color: #fff; }

.ac-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,193,7,.12); border: 1px solid rgba(255,193,7,.25);
    color: #ffc107; padding: 4px 12px; border-radius: 50px; font-size: .75rem; font-weight: 700;
}

.ac-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: linear-gradient(135deg, #e91e8c, #c91a78);
    color: #fff; text-decoration: none;
    padding: 14px 28px; border-radius: 14px;
    font-weight: 800; font-size: .95rem;
    box-shadow: 0 8px 24px rgba(233,30,140,.35);
    transition: .25s;
}
.ac-btn:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(233,30,140,.5); color: #fff; }
.ac-btn-outline {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.05); border: 1px solid rgba(255,255,255,.1);
    color: rgba(255,255,255,.7); text-decoration: none;
    padding: 13px 28px; border-radius: 14px;
    font-weight: 700; font-size: .93rem; transition: .25s;
}
.ac-btn-outline:hover { border-color: rgba(233,30,140,.4); color: #ff6ab4; }
.ac-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
</style>

<div class="ac-wrap">

    <div class="ac-icon"><i class="fa-solid fa-check"></i></div>

    <h1 class="ac-title">Rendez-vous enregistré !</h1>
    <p class="ac-sub">
        @if(auth()->user()->isAdmin())
            Réservation créée et confirmée directement par l'administration.
        @else
            Nous avons bien reçu votre demande. Le salon vous contactera pour confirmer.
        @endif
    </p>

    @if(session('success'))
    <p style="color:#ff6ab4;font-size:.88rem;margin-bottom:20px;">
        <i class="fa-solid fa-circle-check me-1"></i>
        {{ session('success') }}
    </p>
    @endif

    <div class="ac-card">

        <div class="ac-row">
            <span class="ac-lbl">Référence</span>
            <span class="ac-val" style="font-family:monospace;">{{ $reservation->reference }}</span>
        </div>

        <div class="ac-row">
            <span class="ac-lbl">Date</span>
            <span class="ac-val">
                {{ \Carbon\Carbon::parse($reservation->date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
            </span>
        </div>

        <div class="ac-row">
            <span class="ac-lbl">Heure</span>
            <span class="ac-val">{{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}</span>
        </div>

        @if($reservation->employee)
        <div class="ac-row">
            <span class="ac-lbl">Coiffeuse</span>
            <span class="ac-val">{{ $reservation->employee->user->name ?? '—' }}</span>
        </div>
        @endif

        @if($reservation->service)
        <div class="ac-row">
            <span class="ac-lbl">Prestation</span>
            <span class="ac-val">{{ $reservation->service->name }}</span>
        </div>
        @endif

        @if($reservation->client)
        <div class="ac-row">
            <span class="ac-lbl">Client</span>
            <span class="ac-val">{{ $reservation->client->name }}</span>
        </div>
        @endif

        <div class="ac-row">
            <span class="ac-lbl">Statut</span>
            @if($reservation->status === 'confirmed')
            <span class="ac-badge" style="background:rgba(34,197,94,.12);border-color:rgba(34,197,94,.25);color:#4ade80;">
                <i class="fa-solid fa-circle-check"></i> Confirmée
            </span>
            @else
            <span class="ac-badge"><i class="fa-solid fa-clock"></i> En attente de confirmation</span>
            @endif
        </div>

        @if($reservation->client_notes)
        <div class="ac-row">
            <span class="ac-lbl">Notes</span>
            <span class="ac-val" style="font-weight:500;font-size:.85rem;color:rgba(255,255,255,.65);">
                {{ $reservation->client_notes }}
            </span>
        </div>
        @endif

    </div>

    <div class="ac-actions">
        @if(auth()->user()->isAdmin())
            <a href="{{ route('reservations.index') }}" class="ac-btn">
                <i class="fa-solid fa-list-check"></i>
                Toutes les réservations
            </a>
            <a href="{{ route('booking.appointment') }}" class="ac-btn-outline">
                <i class="fa-solid fa-calendar-plus"></i>
                Nouvelle réservation
            </a>
        @else
            <a href="{{ route('client.reservations') }}" class="ac-btn">
                <i class="fa-solid fa-calendar-check"></i>
                Mes réservations
            </a>
            @if($reservation->employee)
            <a href="{{ route('stylists.show', $reservation->employee->id) }}" class="ac-btn-outline">
                <i class="fa-solid fa-user"></i>
                Voir le profil
            </a>
            @else
            <a href="{{ route('home') }}" class="ac-btn-outline">
                <i class="fa-solid fa-house"></i>
                Accueil
            </a>
            @endif
        @endif
    </div>

</div>

@endsection
