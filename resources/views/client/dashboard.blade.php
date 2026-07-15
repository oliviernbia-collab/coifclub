@extends('layouts.client')

@section('title', __('messages.clt_db_title'))

@section('content')

<style>
/* ── Variables ─────────────────── */
:root {
    --pink: #e91e8c;
    --pink-light: #ff6ab4;
    --pink-dark: #c91a78;
    --card: rgba(255,255,255,.05);
    --card-border: rgba(255,255,255,.08);
    --card-hover: rgba(255,255,255,.08);
    --text: rgba(255,255,255,.9);
    --muted: rgba(255,255,255,.45);
    --gradient: linear-gradient(135deg,#e91e8c,#c91a78);
}

/* ── Cards ─────────────────────── */
.db-card {
    background: var(--card);
    border: 1px solid var(--card-border);
    border-radius: 20px;
    padding: 22px;
}
.db-card-title {
    font-size: .95rem;
    font-weight: 700;
    color: var(--text);
    margin: 0;
}
.db-card-link {
    font-size: .8rem;
    font-weight: 700;
    color: var(--pink);
    text-decoration: none;
    transition: opacity .2s;
}
.db-card-link:hover { opacity: .75; }

/* ── Stat cards ────────────────── */
.stat-icon {
    width: 54px; height: 54px;
    border-radius: 50%;
    background: var(--gradient);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 8px 20px rgba(233,30,140,.3);
}

/* ── Appointment items ─────────── */
.rdv-item {
    display: grid;
    grid-template-columns: 80px 1fr auto;
    gap: 14px;
    padding: 16px 0;
    border-bottom: 1px solid rgba(255,255,255,.06);
    align-items: start;
}
.rdv-item:last-child { border-bottom: none; padding-bottom: 0; }
.rdv-img {
    width: 80px; height: 90px;
    border-radius: 12px;
    object-fit: cover;
    background: rgba(255,255,255,.06);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
}
.rdv-info {
    min-width: 0; /* prevents text overflow in grid cell */
}
.rdv-info-line {
    display: flex; align-items: center; gap: 7px;
    font-size: .78rem; color: var(--muted); margin-top: 5px;
    overflow: hidden;
}
.rdv-info-line span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.rdv-info-line i { color: var(--pink); font-size: .7rem; width: 12px; text-align: center; flex-shrink: 0; }

/* ── Badge ─────────────────────── */
.badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 999px;
    font-size: .7rem;
    font-weight: 700;
    white-space: nowrap;
}
.badge-green  { background: rgba(16,185,129,.18); color: #34d399; }
.badge-blue   { background: rgba(59,130,246,.18); color: #60a5fa; }
.badge-purple { background: rgba(139,92,246,.18);  color: #a78bfa; }
.badge-yellow { background: rgba(245,158,11,.18);  color: #fbbf24; }

/* ── Order item ────────────────── */
.order-item {
    display: flex; align-items: center; gap: 14px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(255,255,255,.06);
}
.order-item:last-child { border-bottom: none; padding-bottom: 0; }
.order-thumb {
    width: 48px; height: 48px;
    border-radius: 12px;
    object-fit: cover;
    background: rgba(255,255,255,.06);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; overflow: hidden;
}

/* ── Favorites grid ────────────── */
.fav-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
}
.fav-item { position: relative; }
.fav-img {
    width: 100%; aspect-ratio: 1;
    border-radius: 12px;
    object-fit: cover;
    background: rgba(255,255,255,.06);
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
}
.fav-heart {
    position: absolute; top: 6px; right: 6px;
    width: 24px; height: 24px;
    background: rgba(233,30,140,.85);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
}

/* ── Payment method ────────────── */
.pm-item {
    display: flex; align-items: center; gap: 14px;
    padding: 13px 0;
    border-bottom: 1px solid rgba(255,255,255,.06);
}
.pm-item:last-child { border-bottom: none; }
.pm-logo {
    width: 48px; height: 32px;
    border-radius: 8px;
    border: 1px solid rgba(255,255,255,.12);
    display: flex; align-items: center; justify-content: center;
    background: white;
    flex-shrink: 0;
}

/* ── Notification item ─────────── */
.notif-item {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(255,255,255,.06);
}
.notif-item:last-child { border-bottom: none; padding-bottom: 0; }
.notif-bell {
    width: 34px; height: 34px;
    border-radius: 50%;
    background: rgba(233,30,140,.12);
    border: 1px solid rgba(233,30,140,.2);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; margin-top: 1px;
}

/* ── Responsive ────────────────── */
@media (max-width: 1024px) {
    .db-main-grid { grid-template-columns: 1fr !important; }
    .fav-grid { grid-template-columns: repeat(4, 1fr); }
}
@media (max-width: 640px) {
    .db-stats-grid { grid-template-columns: repeat(2, 1fr) !important; }
    .fav-grid { grid-template-columns: repeat(2, 1fr); }
    .db-loyalty-card { min-width: 0 !important; width: 100% !important; flex-shrink: 1 !important; }

    /* Appointment card : image + info stacked properly */
    .rdv-item {
        grid-template-columns: 70px 1fr;
        gap: 12px;
    }
    .rdv-img {
        width: 70px;
        height: 80px;
    }
    .rdv-item > .rdv-actions {
        grid-column: 1 / -1;
        display: flex;
        justify-content: flex-end;
        padding-top: 4px;
    }
    .rdv-item > .rdv-actions a {
        width: auto;
        text-align: center;
    }
}
@media (max-width: 400px) {
    .db-stats-grid { grid-template-columns: 1fr !important; }
    .fav-grid { grid-template-columns: repeat(2, 1fr); }
    .db-card { padding: 16px; }

    /* Very small screens: stack image above info */
    .rdv-item {
        grid-template-columns: 1fr;
    }
    .rdv-img {
        width: 100%;
        height: 160px;
        border-radius: 14px;
    }
    .rdv-img img { border-radius: 14px; }
    .rdv-item > .rdv-actions {
        grid-column: 1 / -1;
    }
}
</style>

@php
    $user = Auth::user();
    $unreadCount = $user->unreadNotifications()->count();
@endphp

{{-- ══════════════════════════════════════════════════════
     HEADER
══════════════════════════════════════════════════════ --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:20px;margin-bottom:28px;flex-wrap:wrap;">

    <div>
        <h1 style="font-size:2rem;font-weight:800;color:white;margin:0 0 6px;">{{ __('messages.clt_db_title') }}</h1>
        <p style="font-size:.9rem;color:var(--muted);margin:0;">
            {{ __('messages.clt_db_welcome') }}, {{ $user->name }} !
        </p>
    </div>

    {{-- Status card --}}
    <a href="{{ route('client.loyalty') }}" class="db-loyalty-card"
       style="background:var(--card);border:1px solid rgba(233,30,140,.2);border-radius:18px;padding:16px 20px;display:flex;align-items:center;gap:16px;text-decoration:none;min-width:280px;flex-shrink:0;transition:.25s;"
       onmouseover="this.style.borderColor='rgba(233,30,140,.5)'"
       onmouseout="this.style.borderColor='rgba(233,30,140,.2)'">
        <div style="flex:1;">
            <div style="font-size:.75rem;color:var(--muted);font-weight:600;margin-bottom:4px;">{{ __('messages.clt_your_status') }}</div>
            <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;">
                <i class="fa-solid fa-crown" style="color:var(--pink);font-size:.85rem;"></i>
                <span style="font-size:.95rem;font-weight:700;color:var(--pink);">
                    {{ $loyaltyStats['tier'] ?? 'Cliente Premium' }}
                </span>
            </div>
            <div style="font-size:.8rem;color:var(--muted);">
                <strong style="color:white;">{{ $loyaltyStats['balance'] }}</strong> {{ __('messages.clt_loyalty_points') }}
            </div>
        </div>
        <i class="fa-solid fa-chevron-right" style="color:var(--muted);font-size:.8rem;"></i>
    </a>

</div>

{{-- ══════════════════════════════════════════════════════
     STATS
══════════════════════════════════════════════════════ --}}
<div class="db-stats-grid" style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:28px;">

    {{-- Rendez-vous --}}
    <div class="db-card" style="display:flex;align-items:center;gap:16px;">
        <div class="stat-icon"><i class="fa-regular fa-calendar-check" style="color:white;font-size:1.1rem;"></i></div>
        <div>
            <div style="font-size:1.8rem;font-weight:800;color:white;line-height:1;">{{ $totalReservations }}</div>
            <div style="font-size:.82rem;font-weight:600;color:var(--text);margin-top:2px;">{{ __('messages.clt_appointments') }}</div>
            <div style="font-size:.73rem;color:var(--muted);">{{ __('messages.clt_upcoming') }}</div>
        </div>
    </div>

    {{-- Favoris --}}
    <div class="db-card" style="display:flex;align-items:center;gap:16px;">
        <div class="stat-icon"><i class="fa-solid fa-heart" style="color:white;font-size:1.1rem;"></i></div>
        <div>
            <div style="font-size:1.8rem;font-weight:800;color:white;line-height:1;">{{ $favoritesCount }}</div>
            <div style="font-size:.82rem;font-weight:600;color:var(--text);margin-top:2px;">{{ __('messages.favorites') }}</div>
            <div style="font-size:.73rem;color:var(--muted);">{{ __('messages.clt_added') }}</div>
        </div>
    </div>

    {{-- Points fidélité --}}
    <div class="db-card" style="display:flex;align-items:center;gap:16px;">
        <div class="stat-icon"><i class="fa-solid fa-star" style="color:white;font-size:1.1rem;"></i></div>
        <div>
            <div style="font-size:1.8rem;font-weight:800;color:white;line-height:1;">{{ $loyaltyStats['balance'] }}</div>
            <div style="font-size:.82rem;font-weight:600;color:var(--text);margin-top:2px;">{{ __('messages.clt_loyalty_points') }}</div>
            <div style="font-size:.73rem;color:var(--muted);">{{ __('messages.clt_disponible') }}</div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════════
     VIP SUBSCRIPTION CARD
══════════════════════════════════════════════════════ --}}
@if($currentVip && $currentVip->isActive())
<div style="
    background:linear-gradient(135deg,rgba(212,175,55,.1),rgba(212,175,55,.04));
    border:2px solid rgba(212,175,55,.5);
    border-radius:20px; padding:22px 26px; margin-bottom:24px;
    display:flex; align-items:center; justify-content:space-between;
    gap:16px; flex-wrap:wrap;
    box-shadow:0 4px 24px rgba(212,175,55,.12), 0 0 0 1px rgba(212,175,55,.08);
">
    {{-- Icône + infos --}}
    <div style="display:flex;align-items:center;gap:16px;">
        <div style="
            width:50px;height:50px;border-radius:14px;flex-shrink:0;
            background:linear-gradient(135deg,#d4af37,#b8860b);
            display:flex;align-items:center;justify-content:center;
            font-size:20px;color:#0f0f0f;
            box-shadow:0 6px 18px rgba(212,175,55,.35);
        ">
            <i class="fa-solid fa-crown"></i>
        </div>
        <div>
            <div style="font-size:.72rem;color:rgba(255,255,255,.4);font-weight:600;text-transform:uppercase;letter-spacing:.08em;margin-bottom:3px;">
                Abonnement actif
            </div>
            <div style="font-size:.95rem;font-weight:800;color:#d4af37;margin-bottom:4px;">
                Marol VIP ·
                @php $planLabels = ['monthly'=>'Mensuel','quarterly'=>'Trimestriel','annual'=>'Annuel']; @endphp
                {{ $planLabels[$currentVip->plan] ?? $currentVip->plan }}
            </div>
            <div style="font-size:.78rem;color:rgba(255,255,255,.4);">
                Accès jusqu'au <strong style="color:rgba(255,255,255,.7);">{{ $currentVip->ends_at->format('d/m/Y') }}</strong>
            </div>
        </div>
    </div>

    {{-- Avantages pills --}}
    <div style="display:flex;gap:8px;flex-wrap:wrap;flex:1;justify-content:center;">
        <span style="background:rgba(212,175,55,.1);border:1px solid rgba(212,175,55,.2);color:rgba(255,255,255,.6);font-size:.7rem;font-weight:600;padding:4px 12px;border-radius:20px;">
            <i class="fa-solid fa-tag" style="color:#d4af37;margin-right:4px;"></i>{{ $currentVip->discount_percentage }}% de réduction
        </span>
        <span style="background:rgba(212,175,55,.1);border:1px solid rgba(212,175,55,.2);color:rgba(255,255,255,.6);font-size:.7rem;font-weight:600;padding:4px 12px;border-radius:20px;">
            <i class="fa-solid fa-calendar-check" style="color:#d4af37;margin-right:4px;"></i>{{ $currentVip->reservation_count_included }} réservations incluses
        </span>
        @if($currentVip->free_service_monthly)
        <span style="background:rgba(212,175,55,.1);border:1px solid rgba(212,175,55,.2);color:rgba(255,255,255,.6);font-size:.7rem;font-weight:600;padding:4px 12px;border-radius:20px;">
            <i class="fa-solid fa-star" style="color:#d4af37;margin-right:4px;"></i>Service offert/mois
        </span>
        @endif
    </div>

    {{-- Actions --}}
    <div style="display:flex;align-items:center;gap:10px;flex-shrink:0;">
        <a href="{{ route('client.vip.plans') }}" style="
            display:inline-flex;align-items:center;gap:7px;
            background:linear-gradient(135deg,#d4af37,#b8860b);
            color:#0f0f0f;border:none;border-radius:10px;
            padding:10px 18px;font-size:.8rem;font-weight:800;
            text-decoration:none;white-space:nowrap;
            box-shadow:0 4px 14px rgba(212,175,55,.3);
            transition:.2s;
        ">
            <i class="fa-solid fa-crown"></i> Gérer
        </a>
        <button onclick="document.getElementById('dbCancelModal').style.display='flex'" style="
            display:inline-flex;align-items:center;gap:6px;
            background:transparent;border:1.5px solid rgba(248,113,113,.3);
            color:rgba(248,113,113,.65);border-radius:10px;
            padding:9px 14px;font-size:.78rem;font-weight:600;
            cursor:pointer;white-space:nowrap;transition:.18s;
            font-family:'Inter',sans-serif;
        "
        onmouseover="this.style.background='rgba(248,113,113,.08)';this.style.borderColor='rgba(248,113,113,.5)';this.style.color='#f87171';"
        onmouseout="this.style.background='transparent';this.style.borderColor='rgba(248,113,113,.3)';this.style.color='rgba(248,113,113,.65)';">
            <i class="fa-solid fa-xmark"></i> Annuler
        </button>
    </div>
</div>

{{-- ── Modal annulation (dashboard) ──────────────────────── --}}
<div id="dbCancelModal" style="
    display:none;position:fixed;inset:0;z-index:9999;
    background:rgba(0,0,0,.72);backdrop-filter:blur(6px);
    align-items:center;justify-content:center;padding:20px;
" onclick="if(event.target===this)this.style.display='none'">
    <div style="
        background:linear-gradient(135deg,#1a1400,#0f0f0f);
        border:2px solid rgba(248,113,113,.45);
        border-radius:24px;padding:36px 32px;max-width:460px;width:100%;
        box-shadow:0 0 0 1px rgba(248,113,113,.12),0 16px 60px rgba(0,0,0,.7);
        text-align:center;
    ">
        <div style="width:64px;height:64px;border-radius:50%;margin:0 auto 20px;background:rgba(248,113,113,.12);border:1.5px solid rgba(248,113,113,.3);display:flex;align-items:center;justify-content:center;font-size:24px;color:#f87171;box-shadow:0 0 24px rgba(248,113,113,.2);">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 style="font-family:'Playfair Display',serif;font-size:1.3rem;color:#fff;margin:0 0 10px;">
            Annuler votre abonnement ?
        </h3>
        <p style="color:rgba(255,255,255,.45);font-size:.85rem;line-height:1.65;margin:0 0 6px;">
            Vous conserverez tous vos avantages VIP jusqu'au<br>
            <strong style="color:#d4af37;">{{ $currentVip->ends_at->format('d/m/Y') }}</strong>.
        </p>
        <p style="color:rgba(255,255,255,.28);font-size:.76rem;margin:0 0 26px;line-height:1.6;">
            Après cette date, votre accès VIP sera désactivé et vous ne serez plus débité.
        </p>
        <div style="background:rgba(248,113,113,.06);border:1px solid rgba(248,113,113,.18);border-radius:12px;padding:13px 18px;margin-bottom:26px;display:flex;align-items:center;justify-content:space-between;font-size:.82rem;">
            <span style="color:rgba(255,255,255,.4);">Plan actuel</span>
            <span style="color:#f87171;font-weight:700;">
                <i class="fa-solid fa-crown" style="margin-right:5px;"></i>
                @php $planLabels = ['monthly'=>'Mensuel','quarterly'=>'Trimestriel','annual'=>'Annuel']; @endphp
                {{ $planLabels[$currentVip->plan] ?? $currentVip->plan }}
                · {{ number_format($currentVip->price / 100, 2) }}
            </span>
        </div>
        <div style="display:flex;flex-direction:column;gap:10px;">
            <button onclick="document.getElementById('dbCancelModal').style.display='none'" style="background:linear-gradient(135deg,#d4af37,#b8860b);color:#0f0f0f;border:none;border-radius:12px;padding:14px 20px;font-size:.9rem;font-weight:800;cursor:pointer;font-family:'Inter',sans-serif;box-shadow:0 6px 20px rgba(212,175,55,.35);">
                <i class="fa-solid fa-crown" style="margin-right:7px;"></i>
                Maintenir mon abonnement VIP
            </button>
            <form method="POST" action="{{ route('client.vip.cancel') }}">
                @csrf
                <button type="submit" style="background:transparent;border:1.5px solid rgba(248,113,113,.35);color:rgba(248,113,113,.7);border-radius:12px;padding:12px 20px;width:100%;font-size:.84rem;font-weight:600;cursor:pointer;font-family:'Inter',sans-serif;transition:.18s;"
                onmouseover="this.style.background='rgba(248,113,113,.1)';this.style.borderColor='rgba(248,113,113,.55)';this.style.color='#f87171';"
                onmouseout="this.style.background='transparent';this.style.borderColor='rgba(248,113,113,.35)';this.style.color='rgba(248,113,113,.7)';">
                    <i class="fa-solid fa-xmark" style="margin-right:6px;"></i>
                    Confirmer l'annulation
                </button>
            </form>
        </div>
    </div>
</div>

@elseif(!$currentVip || !$currentVip->isActive())
<a href="{{ route('client.vip.plans') }}" style="
    display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;
    background:rgba(212,175,55,.04);
    border:1.5px dashed rgba(212,175,55,.3);
    border-radius:18px;padding:18px 24px;margin-bottom:24px;
    text-decoration:none;transition:.2s;
" onmouseover="this.style.borderColor='rgba(212,175,55,.55)';this.style.background='rgba(212,175,55,.07)';"
   onmouseout="this.style.borderColor='rgba(212,175,55,.3)';this.style.background='rgba(212,175,55,.04)';">
    <div style="display:flex;align-items:center;gap:14px;">
        <div style="width:44px;height:44px;border-radius:12px;background:rgba(212,175,55,.1);border:1.5px solid rgba(212,175,55,.25);display:flex;align-items:center;justify-content:center;font-size:18px;color:#d4af37;">
            <i class="fa-solid fa-crown"></i>
        </div>
        <div>
            <div style="font-size:.88rem;font-weight:700;color:#d4af37;margin-bottom:2px;">Devenir membre VIP</div>
            <div style="font-size:.76rem;color:rgba(255,255,255,.35);">Réductions, priorité de réservation, services offerts</div>
        </div>
    </div>
    <span style="font-size:.78rem;font-weight:700;color:#d4af37;white-space:nowrap;">
        Voir les plans <i class="fa-solid fa-arrow-right" style="margin-left:5px;"></i>
    </span>
</a>
@endif

{{-- ══════════════════════════════════════════════════════
     MAIN GRID : LEFT (appointments+notifs) / RIGHT (orders+fav+pay)
══════════════════════════════════════════════════════ --}}
<div class="db-main-grid" style="display:grid;grid-template-columns:1fr 380px;gap:20px;align-items:start;">

    {{-- ─── LEFT COLUMN ─────────────────────────────── --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Prochains Rendez-vous --}}
        <div class="db-card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
                <h3 class="db-card-title">{{ __('messages.clt_next_appointment') }}</h3>
                <a href="{{ route('client.reservations') }}" class="db-card-link">{{ __('messages.view_all') }}</a>
            </div>

            @forelse($upcomingReservations as $rdv)
            @php
                $badge = match($rdv->status) {
                    'confirmed' => ['class'=>'badge-green', 'label'=>'Confirmé'],
                    'pending'   => ['class'=>'badge-blue',  'label'=>'En attente'],
                    default     => ['class'=>'badge-purple','label'=>'À confirmer'],
                };
                $empName = $rdv->employee?->user?->name ?? $rdv->employee?->name ?? null;
                $salonAddr = $rdv->salon?->address ?? null;
            @endphp

            <div class="rdv-item">

                {{-- Image --}}
                <div class="rdv-img">
                    @if($rdv->service?->image)
                        <img src="{{ asset('storage/'.$rdv->service->image) }}"
                             alt="{{ $rdv->service->name }}"
                             style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <i class="fa-solid fa-scissors" style="color:rgba(255,255,255,.25);font-size:1.4rem;"></i>
                    @endif
                </div>

                {{-- Info --}}
                <div class="rdv-info">
                    <div style="display:flex;align-items:flex-start;gap:8px;margin-bottom:6px;flex-wrap:wrap;">
                        <span style="font-size:.9rem;font-weight:700;color:white;word-break:break-word;">
                            {{ $rdv->service?->name ?? 'Service' }}
                        </span>
                        <span class="badge {{ $badge['class'] }}">{{ $badge['label'] }}</span>
                    </div>
                    <div class="rdv-info-line">
                        <i class="fa-regular fa-calendar"></i>
                        <span>{{ optional($rdv->date)->translatedFormat('l d F Y') ?? '—' }}</span>
                    </div>
                    <div class="rdv-info-line">
                        <i class="fa-regular fa-clock"></i>
                        <span>{{ $rdv->start_time ?? '—' }}</span>
                    </div>
                    @if($empName)
                    <div class="rdv-info-line">
                        <i class="fa-regular fa-user"></i>
                        <span>{{ __('messages.clt_stylist') }}: {{ $empName }}</span>
                    </div>
                    @endif
                    @if($salonAddr)
                    <div class="rdv-info-line">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>{{ $salonAddr }}</span>
                    </div>
                    @endif
                </div>

                {{-- Action --}}
                <div class="rdv-actions">
                    <a href="{{ route('client.reservations') }}"
                       style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border:1.5px solid var(--pink);border-radius:10px;color:var(--pink);font-size:.75rem;font-weight:700;text-decoration:none;transition:.2s;white-space:nowrap;"
                       onmouseover="this.style.background='rgba(233,30,140,.12)'"
                       onmouseout="this.style.background='transparent'">
                        <i class="fa-regular fa-eye" style="font-size:.7rem;"></i>
                        {{ __('messages.clt_see_details') }}
                    </a>
                </div>

            </div>
            @empty
            <div style="text-align:center;padding:30px 0;">
                <div style="width:54px;height:54px;border-radius:50%;background:rgba(233,30,140,.1);border:1px solid rgba(233,30,140,.2);display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                    <i class="fa-regular fa-calendar-xmark" style="color:var(--pink);font-size:1.3rem;"></i>
                </div>
                <p style="color:var(--muted);font-size:.85rem;margin:0 0 14px;">{{ __('messages.clt_no_appointments') }}</p>
                <a href="{{ route('booking.start') }}"
                   style="padding:8px 20px;background:var(--gradient);border-radius:10px;color:#fff;font-size:.8rem;font-weight:700;text-decoration:none;box-shadow:0 6px 18px rgba(233,30,140,.3);">
                    {{ __('messages.clt_book_now') }}
                </a>
            </div>
            @endforelse
        </div>

        {{-- Notifications --}}
        <div class="db-card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
                <h3 class="db-card-title">{{ __('messages.clt_notif_title') }}</h3>
                <a href="{{ route('client.notifications') }}" class="db-card-link">{{ __('messages.view_all') }}</a>
            </div>

            @forelse($recentNotifications as $notif)
            @php
                $nData = $notif->data;
                $nMsg  = $nData['message'] ?? $nData['body'] ?? $nData['title'] ?? 'Notification';
                $nTime = $notif->created_at->diffForHumans();
            @endphp
            <div class="notif-item">
                <div class="notif-bell">
                    <i class="fa-regular fa-bell" style="color:var(--pink);font-size:.75rem;"></i>
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:.82rem;color:var(--text);line-height:1.5;">{{ $nMsg }}</div>
                </div>
                <div style="font-size:.72rem;color:var(--muted);white-space:nowrap;flex-shrink:0;">{{ $nTime }}</div>
            </div>
            @empty
            <p style="color:var(--muted);font-size:.85rem;text-align:center;padding:16px 0;margin:0;">{{ __('messages.clt_no_notifs') }}</p>
            @endforelse
        </div>

    </div>

    {{-- ─── RIGHT COLUMN ────────────────────────────── --}}
    <div style="display:flex;flex-direction:column;gap:20px;">

        {{-- Mes Favoris --}}
        <div class="db-card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                <h3 class="db-card-title">{{ __('messages.favorites') }}</h3>
                <a href="{{ route('client.favorites') }}" class="db-card-link">{{ __('messages.view_all') }}</a>
            </div>

            @if($recentFavorites->isNotEmpty())
            <div class="fav-grid">
                @foreach($recentFavorites as $fav)
                @php $svc = $fav->service; @endphp
                <div class="fav-item">
                    <div class="fav-img">
                        @if($svc?->image_url)
                            <img src="{{ $svc->image_url }}" alt="{{ $svc->name }}"
                                 style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <i class="fa-solid fa-scissors" style="color:rgba(255,255,255,.2);font-size:1.1rem;"></i>
                        @endif
                    </div>
                    <div class="fav-heart">
                        <i class="fa-solid fa-heart" style="color:white;font-size:.6rem;"></i>
                    </div>
                    @if($svc)
                    <div style="font-size:.7rem;color:rgba(255,255,255,.7);margin-top:6px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $svc->name }}</div>
                    <div style="font-size:.7rem;font-weight:700;color:var(--pink);">{{ $svc->formatted_price }}</div>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <p style="color:var(--muted);font-size:.85rem;text-align:center;padding:10px 0;margin:0;">{{ __('messages.clt_no_favorites') }}</p>
            @endif
        </div>

        {{-- Paiements Enregistrés --}}
        <div class="db-card">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;">
                <h3 class="db-card-title">{{ __('messages.clt_saved_payments') }}</h3>
                <a href="{{ route('client.payments') }}" class="db-card-link">{{ __('messages.clt_add') }}</a>
            </div>

            @forelse($recentPayments as $pay)
            @php
                $method = strtolower($pay->method ?? '');
                $isCard = in_array($method, ['card', 'stripe']);
                $isPaypal = $method === 'paypal';
                $isMobile = $method === 'mobile_money';
            @endphp
            <div class="pm-item">
                <div class="pm-logo">
                    @if($isCard)
                        <i class="fa-brands fa-cc-visa" style="font-size:1.5rem;color:#1a1f71;"></i>
                    @elseif($isPaypal)
                        <i class="fa-brands fa-paypal" style="font-size:1.4rem;color:#003087;"></i>
                    @elseif($isMobile)
                        <i class="fa-solid fa-mobile-screen" style="font-size:1.2rem;color:#f97316;"></i>
                    @else
                        <i class="fa-solid fa-money-bill" style="font-size:1.1rem;color:#10b981;"></i>
                    @endif
                </div>
                <div style="flex:1;min-width:0;">
                    <div style="font-size:.85rem;font-weight:600;color:white;">
                        @if($isCard) {{ __('messages.clt_pay_card') }}
                        @elseif($isPaypal) PayPal
                        @elseif($isMobile) {{ __('messages.clt_pay_mobile') }}
                        @else {{ __('messages.clt_pay_cash') }}
                        @endif
                    </div>
                    <div style="font-size:.73rem;color:var(--muted);margin-top:2px;">
                        {{ $pay->created_at->format('d/m/Y') }} · {{ number_format($pay->amount, 0, ',', ' ') }}
                    </div>
                </div>
                <span class="badge {{ $pay->status === 'completed' ? 'badge-green' : 'badge-yellow' }}">
                    {{ $pay->status === 'completed' ? __('messages.clt_paid') : __('messages.pending') }}
                </span>
            </div>
            @empty
            <p style="color:var(--muted);font-size:.85rem;text-align:center;padding:12px 0;margin:0;">{{ __('messages.clt_no_payments') }}</p>
            @endforelse
        </div>

    </div>

</div>

@endsection
