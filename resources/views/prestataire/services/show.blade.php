@extends('layouts.employee')

@section('title', 'Réservations — ' . $service->name)

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

.sb-page { padding: 0 0 60px; }

/* ── BACK ── */
.sb-back {
    display: inline-flex; align-items: center; gap: 8px;
    color: rgba(255,255,255,.5); text-decoration: none;
    font-size: .84rem; font-weight: 600;
    margin-bottom: 20px;
    transition: color .2s;
}
.sb-back:hover { color: #ff6ab4; }
.sb-back i { font-size: .8rem; }

/* ── BANNER ── */
.sb-banner {
    border-radius: 22px;
    padding: 26px 32px;
    background: linear-gradient(135deg, #160d2a 0%, #1e1040 55%, #120e22 100%);
    border: 1px solid rgba(233,30,140,.18);
    position: relative; overflow: hidden;
    margin-bottom: 24px;
    display: flex; align-items: center;
    gap: 24px; flex-wrap: wrap;
}
.sb-banner::before {
    content: ''; position: absolute;
    width: 240px; height: 240px; border-radius: 50%;
    background: rgba(233,30,140,.06);
    top: -90px; right: -70px; pointer-events: none;
}
.sb-banner-img {
    width: 80px; height: 80px; border-radius: 16px;
    object-fit: cover; flex-shrink: 0;
    border: 2px solid rgba(233,30,140,.25);
}
.sb-banner-placeholder {
    width: 80px; height: 80px; border-radius: 16px;
    background: rgba(233,30,140,.1);
    border: 2px solid rgba(233,30,140,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 2.2rem; flex-shrink: 0;
}
.sb-banner-info { flex: 1; min-width: 0; }
.sb-eyebrow {
    font-size: 10px; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
    color: rgba(255,255,255,.4); margin-bottom: 5px;
}
.sb-title {
    font-size: 1.55rem; font-weight: 800;
    color: #fff; margin: 0 0 8px; line-height: 1.2;
}
.sb-meta-pills { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; }
.sb-pill {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; border-radius: 999px;
    font-size: .72rem; font-weight: 700;
}
.sb-pill-cat  { background: rgba(233,30,140,.12); color: #ff6ab4; border: 1px solid rgba(233,30,140,.22); }
.sb-pill-on   { background: rgba(16,185,129,.15);  color: #34d399;  border: 1px solid rgba(16,185,129,.25); }
.sb-pill-off  { background: rgba(239,68,68,.14);   color: #f87171;  border: 1px solid rgba(239,68,68,.22); }
.sb-pill-dur  { background: rgba(255,255,255,.06); color: rgba(255,255,255,.6); border: 1px solid rgba(255,255,255,.08); }
.sb-pill-price { background: rgba(52,211,153,.12); color: #34d399; border: 1px solid rgba(52,211,153,.2); font-size: .82rem; }

/* ── STATS ── */
.sb-stats {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 14px;
    margin-bottom: 28px;
}
@media (max-width: 1100px) { .sb-stats { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 640px)  { .sb-stats { grid-template-columns: repeat(2, 1fr); } }

.sb-stat {
    border-radius: 16px; padding: 16px 18px;
    color: #fff; position: relative; overflow: hidden;
    display: flex; flex-direction: column; gap: 4px;
}
.sb-stat::before {
    content: ''; position: absolute;
    width: 80px; height: 80px; border-radius: 50%;
    background: rgba(255,255,255,.07);
    top: -25px; right: -20px;
}
.sb-stat-lbl  { font-size: .72rem; font-weight: 600; opacity: .8; }
.sb-stat-num  { font-size: 1.75rem; font-weight: 800; line-height: 1; }
.sb-stat-hint { font-size: .68rem; opacity: .55; }
.sb-stat-icon { position: absolute; right: 12px; bottom: 8px; font-size: 2.2rem; opacity: .1; }

.sb-st-total     { background: linear-gradient(135deg, #6b21a8, #7c3aed); }
.sb-st-pending   { background: linear-gradient(135deg, #b45309, #d97706); }
.sb-st-confirmed { background: linear-gradient(135deg, #0369a1, #0ea5e9); }
.sb-st-done      { background: linear-gradient(135deg, #059669, #10b981); }
.sb-st-cancelled { background: linear-gradient(135deg, #be185d, #e91e8c); }
.sb-st-revenue   { background: linear-gradient(135deg, #1e3a5f, #2563eb); }

/* ── TABLE WRAPPER ── */
.sb-card {
    background: rgba(255,255,255,.04);
    border-radius: 20px;
    border: 1px solid rgba(233,30,140,.12);
    overflow: hidden;
}
.sb-card-header {
    padding: 18px 22px;
    border-bottom: 1px solid rgba(255,255,255,.06);
    display: flex; align-items: center; justify-content: space-between; gap: 12px; flex-wrap: wrap;
}
.sb-card-title { font-size: 1rem; font-weight: 800; color: #fff; }
.sb-card-count {
    background: rgba(233,30,140,.12); color: #ff6ab4;
    border: 1px solid rgba(233,30,140,.2);
    border-radius: 999px; padding: 3px 12px;
    font-size: .75rem; font-weight: 700;
}

/* ── TABLE ── */
.sb-table { width: 100%; border-collapse: collapse; }
.sb-table th {
    padding: 12px 18px;
    font-size: .7rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: .08em;
    color: rgba(255,255,255,.35);
    border-bottom: 1px solid rgba(255,255,255,.06);
    text-align: left; white-space: nowrap;
}
.sb-table td {
    padding: 14px 18px;
    border-bottom: 1px solid rgba(255,255,255,.04);
    vertical-align: middle;
}
.sb-table tr:last-child td { border-bottom: none; }
.sb-table tr:hover td { background: rgba(255,255,255,.025); }

.sb-ref { font-size: .78rem; font-weight: 700; color: rgba(255,255,255,.45); font-family: monospace; }
.sb-client-name { font-size: .88rem; font-weight: 700; color: #fff; }
.sb-client-email { font-size: .75rem; color: rgba(255,255,255,.4); margin-top: 2px; }
.sb-date-val { font-size: .85rem; font-weight: 600; color: rgba(255,255,255,.8); }
.sb-time-val { font-size: .75rem; color: rgba(255,255,255,.4); margin-top: 2px; }
.sb-amount { font-size: .9rem; font-weight: 800; color: #34d399; }
.sb-emp { font-size: .8rem; color: rgba(255,255,255,.55); }

.sb-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 11px; border-radius: 999px;
    font-size: .68rem; font-weight: 700;
    letter-spacing: .04em; text-transform: uppercase;
    white-space: nowrap;
}
.sb-badge-pending   { background: rgba(217,119,6,.18);  color: #fbbf24; border: 1px solid rgba(217,119,6,.3); }
.sb-badge-confirmed { background: rgba(14,165,233,.16); color: #38bdf8; border: 1px solid rgba(14,165,233,.28); }
.sb-badge-done      { background: rgba(16,185,129,.16); color: #34d399; border: 1px solid rgba(16,185,129,.28); }
.sb-badge-cancelled { background: rgba(239,68,68,.14);  color: #f87171; border: 1px solid rgba(239,68,68,.24); }
.sb-badge-default   { background: rgba(255,255,255,.08); color: rgba(255,255,255,.5); border: 1px solid rgba(255,255,255,.1); }

/* ── EMPTY ── */
.sb-empty {
    padding: 60px 24px; text-align: center;
}
.sb-empty-icon {
    width: 72px; height: 72px; border-radius: 50%;
    margin: 0 auto 16px;
    background: rgba(233,30,140,.1);
    border: 1px solid rgba(233,30,140,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.8rem; color: #e91e8c;
}
.sb-empty h4 { font-weight: 800; color: #fff; margin-bottom: 8px; }
.sb-empty p  { color: rgba(255,255,255,.45); max-width: 340px; margin: 0 auto; font-size: .87rem; }

/* ── RESPONSIVE ── */
@media (max-width: 768px) {
    .sb-banner { padding: 18px 18px; gap: 16px; }
    .sb-title { font-size: 1.25rem; }
    .sb-table th, .sb-table td { padding: 12px 12px; }
    .sb-col-emp { display: none; }
}
@media (max-width: 576px) {
    .sb-col-ref { display: none; }
    .sb-stats { gap: 10px; }
    .sb-stat-num { font-size: 1.5rem; }
}

</style>

<div class="sb-page">

    {{-- BACK --}}
    <a href="{{ route($routePrefix . '.services') }}" class="sb-back">
        <i class="fa-solid fa-arrow-left"></i> Retour à mes services
    </a>

    {{-- BANNER --}}
    <div class="sb-banner">
        @if($service->image)
            <img src="{{ $service->image_url }}" alt="{{ $service->name }}" class="sb-banner-img">
        @else
            <div class="sb-banner-placeholder">{{ $service->emoji ?? '✂️' }}</div>
        @endif

        <div class="sb-banner-info">
            <div class="sb-eyebrow">Détail du service</div>
            <h1 class="sb-title">{{ $service->name }}</h1>
            <div class="sb-meta-pills">
                <span class="sb-pill sb-pill-cat">
                    <i class="fa-solid fa-tag"></i>
                    {{ $service->categorie?->nom ?? 'Beauté & Coiffure' }}
                </span>
                @if($service->is_active)
                    <span class="sb-pill sb-pill-on"><i class="fa-solid fa-circle-check"></i> Actif</span>
                @else
                    <span class="sb-pill sb-pill-off"><i class="fa-solid fa-circle-xmark"></i> Inactif</span>
                @endif
                <span class="sb-pill sb-pill-dur">
                    <i class="fa-regular fa-clock"></i> {{ $service->formatted_duration }}
                </span>
                <span class="sb-pill sb-pill-price">
                    {{ $service->formatted_price }}
                </span>
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="sb-stats">

        <div class="sb-stat sb-st-total">
            <div class="sb-stat-lbl">Total réservations</div>
            <div class="sb-stat-num">{{ $stats['total'] }}</div>
            <div class="sb-stat-hint">Depuis le début</div>
            <i class="fa-solid fa-calendar-days sb-stat-icon"></i>
        </div>

        <div class="sb-stat sb-st-pending">
            <div class="sb-stat-lbl">En attente</div>
            <div class="sb-stat-num">{{ $stats['pending'] }}</div>
            <div class="sb-stat-hint">À confirmer</div>
            <i class="fa-solid fa-hourglass-half sb-stat-icon"></i>
        </div>

        <div class="sb-stat sb-st-confirmed">
            <div class="sb-stat-lbl">Confirmées</div>
            <div class="sb-stat-num">{{ $stats['confirmed'] }}</div>
            <div class="sb-stat-hint">Prévues</div>
            <i class="fa-solid fa-circle-check sb-stat-icon"></i>
        </div>

        <div class="sb-stat sb-st-done">
            <div class="sb-stat-lbl">Terminées</div>
            <div class="sb-stat-num">{{ $stats['done'] }}</div>
            <div class="sb-stat-hint">Complétées</div>
            <i class="fa-solid fa-star sb-stat-icon"></i>
        </div>

        <div class="sb-stat sb-st-cancelled">
            <div class="sb-stat-lbl">Annulées</div>
            <div class="sb-stat-num">{{ $stats['cancelled'] }}</div>
            <div class="sb-stat-hint">Non réalisées</div>
            <i class="fa-solid fa-ban sb-stat-icon"></i>
        </div>

        <div class="sb-stat sb-st-revenue">
            <div class="sb-stat-lbl">Revenu généré</div>
            <div class="sb-stat-num" style="font-size:1.3rem">
                {{ number_format($stats['revenue'], 0, '.', ',') }}
            </div>
            <div class="sb-stat-hint">Services terminés</div>
            <i class="fa-solid fa-coins sb-stat-icon"></i>
        </div>

    </div>

    {{-- BOOKINGS TABLE --}}
    <div class="sb-card">
        <div class="sb-card-header">
            <div class="sb-card-title">
                <i class="fa-solid fa-list-check me-2" style="color:#e91e8c"></i>
                Historique des réservations
            </div>
            <span class="sb-card-count">{{ $stats['total'] }} réservation{{ $stats['total'] != 1 ? 's' : '' }}</span>
        </div>

        @if($reservations->isEmpty())
            <div class="sb-empty">
                <div class="sb-empty-icon"><i class="fa-solid fa-calendar-xmark"></i></div>
                <h4>Aucune réservation</h4>
                <p>Ce service n'a pas encore été réservé.</p>
            </div>
        @else
            <div style="overflow-x:auto">
                <table class="sb-table">
                    <thead>
                        <tr>
                            <th class="sb-col-ref">Référence</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th class="sb-col-emp">Employé</th>
                            <th>Statut</th>
                            <th>Montant</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $res)
                        <tr>
                            <td class="sb-col-ref">
                                <span class="sb-ref">{{ $res->reference }}</span>
                            </td>
                            <td>
                                <div class="sb-client-name">
                                    {{ $res->client?->name ?? '—' }}
                                </div>
                                <div class="sb-client-email">
                                    {{ $res->client?->email ?? '' }}
                                </div>
                            </td>
                            <td>
                                <div class="sb-date-val">
                                    {{ $res->date ? $res->date->format('d/m/Y') : '—' }}
                                </div>
                                <div class="sb-time-val">
                                    {{ $res->start_time ? \Illuminate\Support\Str::substr($res->start_time, 0, 5) : '' }}
                                    @if($res->end_time)
                                        – {{ \Illuminate\Support\Str::substr($res->end_time, 0, 5) }}
                                    @endif
                                </div>
                            </td>
                            <td class="sb-col-emp">
                                <span class="sb-emp">
                                    {{ $res->employee?->user?->name ?? '—' }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($res->status) {
                                        'pending'   => 'sb-badge-pending',
                                        'confirmed' => 'sb-badge-confirmed',
                                        'done'      => 'sb-badge-done',
                                        'cancelled' => 'sb-badge-cancelled',
                                        default     => 'sb-badge-default',
                                    };
                                    $badgeIcon = match($res->status) {
                                        'pending'   => 'fa-hourglass-half',
                                        'confirmed' => 'fa-circle-check',
                                        'done'      => 'fa-star',
                                        'cancelled' => 'fa-ban',
                                        default     => 'fa-circle',
                                    };
                                @endphp
                                <span class="sb-badge {{ $badgeClass }}">
                                    <i class="fa-solid {{ $badgeIcon }}"></i>
                                    {{ $res->status_label }}
                                </span>
                            </td>
                            <td>
                                <span class="sb-amount">{{ $res->formatted_amount }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>

@endsection
