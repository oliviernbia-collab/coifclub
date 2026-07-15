@extends('layouts.client')

@section('title', 'Réservations')
@section('page-title', 'Gestion des réservations')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
:root{
    --pk:#e91e8c;--pk-light:#ff6ab4;--pk-dark:#c91a78;
    --card:#1a1130;--card2:#120e22;
    --border:rgba(255,255,255,.07);--border-pk:rgba(233,30,140,.15);
    --text:#fff;--muted:rgba(255,255,255,.52);
    --gradient:linear-gradient(135deg,#e91e8c,#c91a78);
}

/* ── HERO ── */
.rv-hero{
    background:linear-gradient(135deg,#0e0a1c 0%,#1a1130 55%,#120e22 100%);
    border:1px solid var(--border-pk);
    border-radius:22px; padding:26px 30px; margin-bottom:22px;
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:16px; position:relative; overflow:hidden;
}
.rv-hero::before{
    content:''; position:absolute; top:-60px; right:-80px;
    width:260px; height:260px; border-radius:50%;
    background:radial-gradient(circle,rgba(233,30,140,.1),transparent 70%);
    pointer-events:none;
}
.rv-hero-left{ display:flex; align-items:center; gap:18px; position:relative; z-index:1; }
.rv-hero-icon{
    width:52px; height:52px; border-radius:16px;
    background:rgba(233,30,140,.12); border:1px solid var(--border-pk);
    display:flex; align-items:center; justify-content:center;
    color:var(--pk); font-size:1.35rem; flex-shrink:0;
}
.rv-hero h2{ font-size:1.3rem; font-weight:800; color:var(--text); margin-bottom:3px; }
.rv-hero p{ color:var(--muted); font-size:.85rem; margin:0; }

.btn-new{
    display:inline-flex; align-items:center; gap:8px;
    background:var(--gradient); color:#fff;
    padding:12px 22px; border-radius:13px;
    font-weight:700; font-size:.88rem; text-decoration:none;
    transition:.25s; box-shadow:0 6px 20px rgba(233,30,140,.3);
    position:relative; z-index:1; white-space:nowrap;
}
.btn-new:hover{ transform:translateY(-2px); box-shadow:0 10px 28px rgba(233,30,140,.42); color:#fff; }

/* ── TOOLBAR ── */
.rv-toolbar{
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:12px; margin-bottom:18px;
}
.rv-search{
    position:relative; flex:1; max-width:320px; min-width:200px;
}
.rv-search i{
    position:absolute; left:13px; top:50%; transform:translateY(-50%);
    color:rgba(233,30,140,.5); font-size:12.5px; pointer-events:none;
}
.rv-search input{
    width:100%; padding:10px 14px 10px 36px;
    background:var(--card); border:1.5px solid var(--border-pk);
    border-radius:12px; color:var(--text); font-size:.88rem; outline:none;
    transition:border-color .2s, box-shadow .2s;
}
.rv-search input:focus{ border-color:var(--pk); box-shadow:0 0 0 3px rgba(233,30,140,.1); }
.rv-search input::placeholder{ color:rgba(255,255,255,.28); }

/* ── TABLE CARD ── */
.rv-card{
    background:var(--card);
    border:1px solid var(--border-pk);
    border-radius:22px; overflow:hidden;
    box-shadow:0 8px 30px rgba(0,0,0,.22);
}

/* ── TABLE ── */
.rv-table{ width:100%; border-collapse:collapse; }
.rv-table thead tr{
    background:rgba(233,30,140,.05);
    border-bottom:1px solid var(--border-pk);
}
.rv-table thead th{
    padding:13px 18px;
    font-size:10.5px; font-weight:700; letter-spacing:1.4px;
    text-transform:uppercase; color:rgba(255,255,255,.35);
    white-space:nowrap;
}
.rv-table tbody tr{
    border-bottom:1px solid rgba(255,255,255,.04);
    transition:background .15s;
}
.rv-table tbody tr:last-child{ border-bottom:none; }
.rv-table tbody tr:hover{ background:rgba(233,30,140,.04); }
.rv-table td{
    padding:15px 18px; vertical-align:middle;
    font-size:13.5px; color:rgba(255,255,255,.85);
}

/* Avatar */
.rv-avatar{
    width:38px; height:38px; border-radius:50%;
    border:2px solid var(--border-pk); object-fit:cover; flex-shrink:0;
}
.rv-client-name{ font-weight:700; color:var(--text); font-size:13.5px; }
.rv-client-email{ color:var(--muted); font-size:11.5px; }

/* Service */
.rv-svc-name{ font-weight:700; color:var(--text); }
.rv-svc-meta{ color:var(--muted); font-size:12px; }

/* Date/Time */
.rv-date{ font-weight:600; color:var(--text); font-size:13px; }
.rv-time{
    display:inline-flex; align-items:center; gap:4px;
    background:rgba(233,30,140,.1); color:var(--pk-light);
    padding:3px 10px; border-radius:8px;
    font-size:12.5px; font-weight:700;
}

/* Price */
.rv-price{ font-weight:900; font-size:14px; color:var(--text); }
.rv-price-sub{ font-size:11px; font-weight:500; color:var(--muted); }

/* Status badges */
.rv-badge{
    display:inline-flex; align-items:center; gap:5px;
    padding:5px 12px; border-radius:99px;
    font-size:11.5px; font-weight:700; white-space:nowrap;
}
.rv-badge-confirmed{ background:rgba(74,222,128,.12); color:#4ade80; }
.rv-badge-pending  { background:rgba(251,191,36,.12);  color:#fbbf24; }
.rv-badge-cancelled{ background:rgba(248,113,113,.12); color:#f87171; }
.rv-badge-done     { background:rgba(148,163,184,.1);  color:#94a3b8; }

/* Actions */
.rv-actions{ display:flex; align-items:center; justify-content:flex-end; gap:7px; }
.btn-act{
    width:34px; height:34px; border-radius:10px;
    display:inline-flex; align-items:center; justify-content:center;
    font-size:13px; cursor:pointer; transition:.2s; text-decoration:none; border:1.5px solid transparent;
}
.btn-act-edit{
    background:rgba(233,30,140,.1); border-color:var(--border-pk); color:var(--pk);
}
.btn-act-edit:hover{
    background:var(--pk); border-color:var(--pk); color:#fff; transform:translateY(-1px);
}
.btn-act-del{
    background:rgba(248,113,113,.08); border-color:rgba(248,113,113,.2); color:#f87171;
}
.btn-act-del:hover{
    background:#ef4444; border-color:#ef4444; color:#fff; transform:translateY(-1px);
}

/* Empty */
.rv-empty{ text-align:center; padding:60px 30px; }
.rv-empty-icon{
    width:76px; height:76px; border-radius:50%;
    background:rgba(233,30,140,.08); border:1px solid var(--border-pk);
    display:flex; align-items:center; justify-content:center;
    margin:0 auto 18px; font-size:28px; color:var(--pk);
}
.rv-empty h5{ font-weight:800; color:var(--text); margin-bottom:7px; }
.rv-empty p{ color:var(--muted); font-size:13.5px; }

/* ── MOBILE CARD LAYOUT (≤640px) ── */
@media(max-width:640px){
    .rv-card{ border-radius:18px; }
    .rv-table thead{ display:none; }
    .rv-table, .rv-table tbody{ display:block; width:100%; }

    .rv-table tbody tr{
        display:block;
        margin:0 12px 12px;
        padding:16px;
        border-radius:16px;
        background:rgba(255,255,255,.03);
        border:1px solid rgba(255,255,255,.07) !important;
        border-bottom:1px solid rgba(255,255,255,.07) !important;
    }
    .rv-table tbody tr:last-child{ margin-bottom:14px; }
    .rv-table tbody tr:hover{ background:rgba(233,30,140,.04); }

    .rv-table tbody td{
        display:flex; align-items:flex-start; gap:10px;
        padding:6px 0; border:none !important; font-size:13px;
    }
    .rv-table tbody td::before{
        content:attr(data-label);
        font-size:9.5px; font-weight:700; letter-spacing:.09em;
        text-transform:uppercase; color:rgba(255,255,255,.3);
        min-width:72px; flex-shrink:0; padding-top:3px;
    }
    /* Dernière colonne (Actions) : pas de label, centrée */
    .rv-table tbody td:last-child{ justify-content:flex-end; }
    .rv-table tbody td:last-child::before{ display:none; }

    .rv-hero{ padding:18px; }
    .rv-toolbar{ flex-direction:column; align-items:stretch; }
    .rv-search{ max-width:100%; }
}

@media(max-width:420px){
    .rv-hero{ flex-direction:column; align-items:flex-start; }
    .btn-new{ width:100%; justify-content:center; }
}
</style>

{{-- HERO --}}
<div class="rv-hero">
    <div class="rv-hero-left">
        <div class="rv-hero-icon"><i class="fa-solid fa-calendar-check"></i></div>
        <div>
            <h2>Réservations</h2>
            <p>Gérez et suivez tous les rendez-vous</p>
        </div>
    </div>
    <a href="{{ route('reservations.create') }}" class="btn-new">
        <i class="fa-solid fa-plus"></i> Nouvelle réservation
    </a>
</div>

{{-- TOOLBAR --}}
<div class="rv-toolbar">
    <div class="rv-search">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="rv-search" placeholder="Rechercher une réservation…">
    </div>
</div>

{{-- TABLE --}}
<div class="rv-card">
    <div class="table-responsive" style="overflow-x:auto;">
        <table class="rv-table" id="rv-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Montant</th>
                    <th>Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                @php
                    $status = $reservation->status;
                    $badgeClass = match(true){
                        in_array($status,['confirmee','confirmed']) => 'rv-badge-confirmed',
                        in_array($status,['en_attente','pending'])  => 'rv-badge-pending',
                        in_array($status,['annulee','cancelled'])   => 'rv-badge-cancelled',
                        default                                      => 'rv-badge-done',
                    };
                    $badgeIcon = match(true){
                        in_array($status,['confirmee','confirmed']) => 'fa-circle-check',
                        in_array($status,['en_attente','pending'])  => 'fa-hourglass-half',
                        in_array($status,['annulee','cancelled'])   => 'fa-circle-xmark',
                        default                                      => 'fa-flag-checkered',
                    };
                    $badgeLabel = match(true){
                        in_array($status,['confirmee','confirmed']) => 'Confirmée',
                        in_array($status,['en_attente','pending'])  => 'En attente',
                        in_array($status,['annulee','cancelled'])   => 'Annulée',
                        default                                      => 'Terminée',
                    };
                @endphp
                <tr>
                    <td data-label="Cliente">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($reservation->client->name ?? 'C') }}&background=1a1130&color=e91e8c&bold=true&size=80"
                                 class="rv-avatar" alt="avatar">
                            <div>
                                <div class="rv-client-name">{{ $reservation->client->name ?? 'Inconnu' }}</div>
                                <div class="rv-client-email">{{ $reservation->client->email ?? '—' }}</div>
                            </div>
                        </div>
                    </td>
                    <td data-label="Service">
                        <div class="rv-svc-name">{{ $reservation->service->nom ?? 'Service supprimé' }}</div>
                        @if(!empty($reservation->service->duree))
                        <div class="rv-svc-meta"><i class="fa-regular fa-clock me-1"></i>{{ $reservation->service->duree }} min</div>
                        @endif
                    </td>
                    <td data-label="Date">
                        <span class="rv-date">
                            {{ \Carbon\Carbon::parse($reservation->date_reservation)->format('d/m/Y') }}
                        </span>
                    </td>
                    <td data-label="Heure">
                        <span class="rv-time">
                            <i class="fa-regular fa-clock" style="font-size:10px;"></i>
                            {{ $reservation->heure_reservation }}
                        </span>
                    </td>
                    <td data-label="Montant">
                        <span class="rv-price">
                            {{ number_format($reservation->service->prix ?? 0, 0, ',', ' ') }}
                        </span>
                    </td>
                    <td data-label="Statut">
                        <span class="rv-badge {{ $badgeClass }}">
                            <i class="fa-solid {{ $badgeIcon }}" style="font-size:9px;"></i>
                            {{ $badgeLabel }}
                        </span>
                    </td>
                    <td>
                        <div class="rv-actions">
                            <a href="{{ route('reservations.edit', $reservation->id) }}"
                               class="btn-act btn-act-edit" title="Modifier">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-act btn-act-del" title="Supprimer"
                                        onclick="return confirm('Supprimer cette réservation ?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="rv-empty">
                            <div class="rv-empty-icon"><i class="fa-solid fa-calendar-xmark"></i></div>
                            <h5>Aucune réservation</h5>
                            <p>Aucune réservation trouvée pour le moment.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
document.getElementById('rv-search').addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#rv-table tbody tr').forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>

@endsection
