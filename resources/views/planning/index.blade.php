@extends('layouts.employee')
@section('title', __('messages.planning_reservations_title', [], 'Planning'))
@section('page-subtitle', __('messages.planning_subtitle', [], 'Gérez votre agenda et vos rendez-vous'))

@section('content')

<style>
/* ── Stats ── */
.pl-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
@media(max-width:900px) { .pl-stats { grid-template-columns:repeat(2,1fr); } }
@media(max-width:480px) { .pl-stats { grid-template-columns:1fr 1fr; } }

/* ── Hero ── */
.pl-hero {
    position:relative; border-radius:22px; overflow:hidden;
    margin-bottom:24px; height:148px;
    background:linear-gradient(135deg,#1a0e2e 0%,#0e0a1c 60%,rgba(212,175,55,.08) 100%);
    border:1px solid rgba(212,175,55,.15);
}
.pl-hero-deco {
    position:absolute; right:-40px; top:-40px;
    width:220px; height:220px; border-radius:50%;
    background:radial-gradient(circle,rgba(212,175,55,.15),transparent 70%);
    pointer-events:none;
}
.pl-hero-deco2 {
    position:absolute; left:-20px; bottom:-30px;
    width:160px; height:160px; border-radius:50%;
    background:radial-gradient(circle,rgba(212,175,55,.08),transparent 70%);
    pointer-events:none;
}
.pl-hero-content {
    position:relative; z-index:2;
    padding:28px 32px; height:100%;
    display:flex; flex-direction:column; justify-content:center;
}
.pl-hero-eyebrow {
    font-size:.7rem; font-weight:700; letter-spacing:.12em;
    text-transform:uppercase; color:rgba(212,175,55,.9);
    margin-bottom:8px; display:flex; align-items:center; gap:7px;
}
.pl-hero-title {
    font-size:1.65rem; font-weight:800; color:#fff; margin:0 0 4px;
    line-height:1.15;
}
.pl-hero-title span {
    background:linear-gradient(135deg,#d4af37,#f5d06f);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
}
.pl-hero-sub { color:rgba(255,255,255,.5); font-size:.85rem; margin:0; }
.pl-hero-icon {
    position:absolute; right:36px; top:50%; transform:translateY(-50%);
    font-size:4.5rem; color:rgba(212,175,55,.12);
    pointer-events:none; z-index:1;
}

/* ── Week agenda ── */
.pl-agenda-nav {
    display:flex; align-items:center; justify-content:space-between;
    margin-bottom:16px; flex-wrap:wrap; gap:10px;
}
.pl-agenda-heading {
    font-size:.95rem; font-weight:800; color:#fff;
    display:flex; align-items:center; gap:8px;
}
.pl-week-label { font-size:.78rem; color:rgba(255,255,255,.4); font-weight:500; margin-top:2px; }
.pl-nav-btns { display:flex; gap:7px; }
.pl-nav-btn {
    background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.1);
    color:rgba(255,255,255,.65); border-radius:10px;
    padding:7px 14px; font-size:12.5px; font-weight:700;
    text-decoration:none; transition:.2s;
    display:inline-flex; align-items:center; gap:5px;
}
.pl-nav-btn:hover { background:rgba(212,175,55,.12); border-color:rgba(212,175,55,.3); color:#f5d06f; }
.pl-nav-btn.today-btn { background:rgba(212,175,55,.1); border-color:rgba(212,175,55,.25); color:#f5d06f; }

.pl-agenda-scroll { overflow-x:auto; border-radius:16px; border:1px solid rgba(255,255,255,.07); }
.pl-agenda-table { width:100%; min-width:660px; border-collapse:collapse; table-layout:fixed; }

.pl-agenda-table th {
    padding:10px 6px; text-align:center; font-size:10.5px;
    font-weight:700; text-transform:uppercase; letter-spacing:.06em;
    color:rgba(255,255,255,.4); background:rgba(255,255,255,.03);
    border-bottom:1px solid rgba(255,255,255,.07); white-space:nowrap;
}
.pl-agenda-table th.is-today { color:#d4af37; background:rgba(212,175,55,.07); }
.pl-agenda-table th:first-child { width:56px; min-width:56px; }

.pl-time-cell {
    padding:0 6px; text-align:right; font-size:10px; font-weight:700;
    color:rgba(255,255,255,.25); white-space:nowrap; vertical-align:top;
    padding-top:5px; background:rgba(255,255,255,.02);
    border-right:1px solid rgba(255,255,255,.05);
}
.pl-slot {
    height:48px; border-bottom:1px solid rgba(255,255,255,.04);
    border-right:1px solid rgba(255,255,255,.04);
    vertical-align:top; padding:3px 3px; position:relative;
}
.pl-slot.is-today-col { background:rgba(212,175,55,.03); }
.pl-slot.has-rdv { background:rgba(212,175,55,.09); }

.pl-rdv-pill {
    display:block; border-radius:7px; padding:3px 6px;
    font-size:10px; font-weight:700; color:#fff;
    line-height:1.3; overflow:hidden; text-overflow:ellipsis;
    white-space:nowrap; cursor:default; margin-bottom:2px;
    border:1px solid rgba(255,255,255,.1);
    transition:transform .15s;
}
.pl-rdv-pill:hover { transform:scale(1.03); z-index:5; position:relative; }
.pl-rdv-pill.pill-confirmed { background:rgba(37,99,235,.75); border-color:rgba(96,165,250,.3); }
.pl-rdv-pill.pill-pending   { background:rgba(217,119,6,.75); border-color:rgba(251,191,36,.3); }
.pl-rdv-pill.pill-done      { background:rgba(22,163,74,.75); border-color:rgba(74,222,128,.3); }
.pl-rdv-pill.pill-other     { background:rgba(212,175,55,.7); border-color:rgba(255,106,180,.3); }
.pl-pill-service { display:block; opacity:.75; font-size:9px; }

/* ── Today section ── */
.pl-today-empty {
    text-align:center; padding:22px 12px;
    color:rgba(255,255,255,.3); font-size:.82rem;
}
.pl-today-empty i { font-size:1.6rem; display:block; margin-bottom:6px; opacity:.4; }

/* ── Upcoming list ── */
.pl-upcoming-row {
    display:flex; align-items:center; gap:12px;
    padding:13px 20px; border-bottom:1px solid rgba(255,255,255,.05);
    transition:background .15s;
}
.pl-upcoming-row:last-child { border-bottom:none; }
.pl-upcoming-row:hover { background:rgba(255,255,255,.02); }

.pl-date-box {
    flex-shrink:0; width:48px; text-align:center;
    background:rgba(212,175,55,.1); border:1px solid rgba(212,175,55,.2);
    border-radius:12px; padding:6px 4px;
}
.pl-date-day  { font-size:1.2rem; font-weight:800; color:#f5d06f; line-height:1; }
.pl-date-mon  { font-size:.62rem; font-weight:700; color:rgba(255,255,255,.45); text-transform:uppercase; }

.pl-rdv-info { flex:1; min-width:0; }
.pl-rdv-name { font-size:.85rem; font-weight:700; color:#fff; }
.pl-rdv-meta { font-size:.75rem; color:rgba(255,255,255,.4); margin-top:2px; }

.pl-status-chip {
    flex-shrink:0; display:inline-flex; align-items:center; gap:4px;
    font-size:.7rem; font-weight:700; padding:4px 10px; border-radius:999px;
}
.chip-confirmed { background:rgba(37,99,235,.15); color:#60a5fa; }
.chip-pending   { background:rgba(251,191,36,.12); color:#fbbf24; }
.chip-done      { background:rgba(74,222,128,.12); color:#4ade80; }
.chip-cancelled { background:rgba(248,113,113,.1); color:#f87171; }

/* ── Legend ── */
.pl-legend {
    display:flex; gap:14px; flex-wrap:wrap; margin-top:12px;
    padding-top:12px; border-top:1px solid rgba(255,255,255,.06);
}
.pl-legend-item { display:flex; align-items:center; gap:6px; font-size:11px; color:rgba(255,255,255,.45); }
.pl-legend-dot { width:10px; height:10px; border-radius:3px; flex-shrink:0; }

/* ── Grille ── */
.pl-grid2 { display:grid; grid-template-columns:1fr 2fr; gap:20px; margin-bottom:20px; }
@media(max-width:900px) { .pl-grid2 { grid-template-columns:1fr; } }
</style>

{{-- ── HERO ── --}}
<div class="pl-hero">
    <div class="pl-hero-deco"></div>
    <div class="pl-hero-deco2"></div>
    <i class="fa-solid fa-calendar-days pl-hero-icon"></i>
    <div class="pl-hero-content">
        <div class="pl-hero-eyebrow">
            <i class="fa-solid fa-calendar-week"></i>
            {{ __('messages.planning_eyebrow', [], 'Planning') }}
        </div>
        <h1 class="pl-hero-title">
            {{ __('messages.planning_reservations_title', [], 'Planning des') }}
            <span>{{ __('messages.reservations', [], 'Réservations') }}</span>
        </h1>
        <p class="pl-hero-sub">{{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</p>
    </div>
</div>

{{-- ── STATS ── --}}
<div class="pl-stats">
    <div class="emp-stat-dark">
        <div class="emp-stat-icon" style="background:rgba(212,175,55,.25);">
            <i class="fa-solid fa-calendar-days" style="color:#f5d06f;font-size:20px;"></i>
        </div>
        <div>
            <div class="emp-stat-num">{{ $stats['total'] }}</div>
            <div class="emp-stat-lbl">{{ __('messages.planning_total') }}</div>
            <div class="emp-stat-sub">{{ __('messages.reservations') }}</div>
        </div>
    </div>

    <div class="emp-stat-dark">
        <div class="emp-stat-icon" style="background:rgba(251,191,36,.2);">
            <i class="fa-solid fa-clock" style="color:#fbbf24;font-size:20px;"></i>
        </div>
        <div>
            <div class="emp-stat-num">{{ $stats['today'] }}</div>
            <div class="emp-stat-lbl">{{ __('messages.today_label') }}</div>
            <div class="emp-stat-sub">{{ __('messages.planning_rdv') }}</div>
        </div>
    </div>

    <div class="emp-stat-dark">
        <div class="emp-stat-icon" style="background:rgba(37,99,235,.25);">
            <i class="fa-solid fa-circle-check" style="color:#60a5fa;font-size:20px;"></i>
        </div>
        <div>
            <div class="emp-stat-num">{{ $stats['confirmed'] }}</div>
            <div class="emp-stat-lbl">{{ __('messages.status_confirmed') }}</div>
            <div class="emp-stat-sub">{{ __('messages.planning_rdv') }}</div>
        </div>
    </div>

    <div class="emp-stat-dark">
        <div class="emp-stat-icon" style="background:rgba(245,158,11,.2);">
            <i class="fa-solid fa-hourglass-half" style="color:#f59e0b;font-size:20px;"></i>
        </div>
        <div>
            <div class="emp-stat-num">{{ $stats['pending'] }}</div>
            <div class="emp-stat-lbl">{{ __('messages.status_pending') }}</div>
            <div class="emp-stat-sub">{{ __('messages.planning_rdv') }}</div>
        </div>
    </div>
</div>

{{-- ── AGENDA SEMAINE ── --}}
<div class="emp-card-dark" style="margin-bottom:20px;">
    <div class="emp-card-head">
        <div>
            <div class="pl-agenda-heading">
                <i class="fa-solid fa-calendar-week" style="color:#d4af37;"></i>
                {{ __('messages.calendar_overview', [], 'Agenda de la semaine') }}
            </div>
            <div class="pl-week-label">
                {{ $weekStart->locale(app()->getLocale())->isoFormat('D MMM') }} → {{ $weekEnd->locale(app()->getLocale())->isoFormat('D MMM YYYY') }}
            </div>
        </div>
        <div class="pl-nav-btns">
            <a href="?week={{ $weekOffset - 1 }}" class="pl-nav-btn">
                <i class="fa-solid fa-chevron-left"></i> {{ __('messages.planning_prev') }}
            </a>
            <a href="?week=0" class="pl-nav-btn today-btn">
                <i class="fa-solid fa-circle-dot"></i> {{ __('messages.planning_today_short') }}
            </a>
            <a href="?week={{ $weekOffset + 1 }}" class="pl-nav-btn">
                {{ __('messages.planning_next') }} <i class="fa-solid fa-chevron-right"></i>
            </a>
        </div>
    </div>

    <div class="emp-card-body" style="padding:16px 20px;">
        <div class="pl-agenda-scroll">
            <table class="pl-agenda-table">
                <thead>
                    <tr>
                        <th></th>
                        @foreach($weekDays as $col)
                        <th class="{{ $col['isToday'] ? 'is-today' : '' }}">
                            {{ $col['label'] }}
                            @if($col['isToday'])<br><span style="color:#d4af37;font-size:8px;">● {{ __('messages.planning_today_short') }}</span>@endif
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($timeSlots as $slot)
                    <tr>
                        <td class="pl-time-cell">{{ $slot }}</td>
                        @foreach($weekDays as $col)
                        @php
                            $cellRdv = $agendaMap[$col['date']][$slot] ?? [];
                            $hasRdv  = count($cellRdv) > 0;
                        @endphp
                        <td class="pl-slot {{ $col['isToday'] ? 'is-today-col' : '' }} {{ $hasRdv ? 'has-rdv' : '' }}">
                            @foreach($cellRdv as $r)
                            @php
                                $pillClass = match($r->status) {
                                    'confirmed' => 'pill-confirmed',
                                    'pending'   => 'pill-pending',
                                    'done'      => 'pill-done',
                                    default     => 'pill-other',
                                };
                            @endphp
                            <span class="pl-rdv-pill {{ $pillClass }}"
                                  title="{{ $r->client?->name }} · {{ $r->service?->name }} · {{ substr($r->start_time,0,5) }}">
                                {{ substr($r->client?->name ?? 'Cliente', 0, 12) }}
                                <span class="pl-pill-service">{{ substr($r->service?->name ?? '', 0, 14) }}</span>
                            </span>
                            @endforeach
                        </td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Légende --}}
        <div class="pl-legend">
            <div class="pl-legend-item">
                <div class="pl-legend-dot" style="background:rgba(37,99,235,.8);"></div> {{ __('messages.status_confirmed') }}
            </div>
            <div class="pl-legend-item">
                <div class="pl-legend-dot" style="background:rgba(217,119,6,.8);"></div> {{ __('messages.status_pending') }}
            </div>
            <div class="pl-legend-item">
                <div class="pl-legend-dot" style="background:rgba(22,163,74,.8);"></div> {{ __('messages.status_done') }}
            </div>
            <div class="pl-legend-item">
                <div class="pl-legend-dot" style="background:rgba(212,175,55,.7);"></div> {{ __('messages.planning_legend_other') }}
            </div>
            <div class="pl-legend-item" style="margin-left:auto;">
                <i class="fa-solid fa-circle-info" style="color:rgba(255,255,255,.3);font-size:11px;"></i>
                {{ __('messages.planning_hover_hint') }}
            </div>
        </div>
    </div>
</div>

{{-- ── GRID : RDV AUJOURD'HUI + PROCHAINS ── --}}
<div class="pl-grid2">

    {{-- Aujourd'hui --}}
    <div class="emp-card-dark">
        <div class="emp-card-head">
            <h3 class="emp-card-title">
                <i class="fa-solid fa-calendar-day" style="color:#d4af37;margin-right:8px;"></i>
                {{ __('messages.today_reservations', [], "Aujourd'hui") }}
            </h3>
            <span class="emp-badge-dark">{{ $todayRdv->count() }}</span>
        </div>

        @if($todayRdv->isEmpty())
        <div class="pl-today-empty">
            <i class="fa-regular fa-calendar-xmark"></i>
            {{ __('messages.no_reservations_today', [], 'Aucun RDV aujourd\'hui') }}
        </div>
        @else
        @foreach($todayRdv as $r)
        @php
            $sc = match($r->status) {
                'confirmed' => ['chip-confirmed', __('messages.status_confirmed', [], 'Confirmé')],
                'done'      => ['chip-done',      __('messages.status_done', [], 'Terminé')],
                'cancelled' => ['chip-cancelled', __('messages.status_cancelled', [], 'Annulé')],
                default     => ['chip-pending',   __('messages.status_pending', [], 'En attente')],
            };
        @endphp
        <div class="emp-plan-dark">
            <div style="display:flex;align-items:center;gap:11px;">
                <div class="emp-icon-box-dark">
                    <i class="fa-solid fa-scissors" style="color:#d4af37;font-size:14px;"></i>
                </div>
                <div>
                    <div style="font-size:.85rem;font-weight:700;color:#fff;">{{ $r->service?->name ?? 'Service' }}</div>
                    <div style="font-size:.74rem;color:rgba(255,255,255,.45);margin-top:2px;">
                        <i class="fa-regular fa-clock" style="margin-right:3px;"></i>{{ substr($r->start_time,0,5) }}
                        @if($r->client) · {{ $r->client->name }} @endif
                    </div>
                </div>
            </div>
            <span class="pl-status-chip {{ $sc[0] }}">{{ $sc[1] }}</span>
        </div>
        @endforeach
        @endif
    </div>

    {{-- Prochains RDV --}}
    <div class="emp-card-dark">
        <div class="emp-card-head">
            <h3 class="emp-card-title">
                <i class="fa-solid fa-calendar-days" style="color:#d4af37;margin-right:8px;"></i>
                {{ __('messages.upcoming_reservations_label', [], 'Prochains rendez-vous') }}
            </h3>
            @if($upcoming->isNotEmpty())
            <span class="emp-badge-dark">{{ $upcoming->count() }}</span>
            @endif
        </div>

        @if($upcoming->isEmpty())
        <div class="pl-today-empty">
            <i class="fa-regular fa-calendar-check"></i>
            {{ __('messages.no_upcoming_this_week', [], 'Aucun RDV à venir') }}
        </div>
        @else
        @foreach($upcoming as $r)
        @php
            $sc2 = match($r->status) {
                'confirmed' => ['chip-confirmed', __('messages.status_confirmed', [], 'Confirmé')],
                'done'      => ['chip-done',      __('messages.status_done', [], 'Terminé')],
                'cancelled' => ['chip-cancelled', __('messages.status_cancelled', [], 'Annulé')],
                default     => ['chip-pending',   __('messages.status_pending', [], 'En attente')],
            };
        @endphp
        <div class="pl-upcoming-row">
            <div class="pl-date-box">
                <div class="pl-date-day">{{ $r->date->format('d') }}</div>
                <div class="pl-date-mon">{{ $r->date->locale(app()->getLocale())->isoFormat('MMM') }}</div>
            </div>
            <div class="pl-rdv-info">
                <div class="pl-rdv-name">{{ $r->service?->name ?? 'Service' }}</div>
                <div class="pl-rdv-meta">
                    <i class="fa-regular fa-clock" style="margin-right:3px;"></i>{{ substr($r->start_time,0,5) }}
                    @if($r->client) &nbsp;·&nbsp; <i class="fa-regular fa-user" style="margin-right:2px;"></i>{{ $r->client->name }} @endif
                </div>
            </div>
            <span class="pl-status-chip {{ $sc2[0] }}">{{ $sc2[1] }}</span>
        </div>
        @endforeach
        @endif
    </div>

</div>

{{-- ── LISTE COMPLÈTE ── --}}
<div class="emp-card-dark">
    <div class="emp-card-head">
        <h3 class="emp-card-title">
            <i class="fa-solid fa-list-ul" style="color:#d4af37;margin-right:8px;"></i>
            {{ __('messages.recent_appointments_list', [], 'Tous les rendez-vous') }}
        </h3>
        <a href="{{ route('employee.reservations') }}" class="emp-link">
            {{ __('messages.view_all', [], 'Gérer') }} <i class="fa-solid fa-arrow-right" style="margin-left:4px;"></i>
        </a>
    </div>

    @if($allReservations->isEmpty())
    <div class="pl-today-empty" style="padding:40px 20px;">
        <i class="fa-regular fa-calendar-xmark" style="font-size:2rem;"></i>
        <div style="font-size:.9rem;margin-top:8px;">{{ __('messages.no_reservations_title', [], 'Aucune réservation') }}</div>
    </div>
    @else
    <div style="overflow-x:auto;">
        <table style="width:100%;border-collapse:collapse;">
            <thead>
                <tr>
                    <th style="padding:12px 18px;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:rgba(255,255,255,.45);background:rgba(212,175,55,.07);border-bottom:1px solid rgba(212,175,55,.15);white-space:nowrap;">
                        <i class="fa-regular fa-calendar" style="margin-right:5px;"></i>{{ __('messages.col_date_time', [], 'Date') }}
                    </th>
                    <th style="padding:12px 18px;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:rgba(255,255,255,.45);background:rgba(212,175,55,.07);border-bottom:1px solid rgba(212,175,55,.15);">
                        <i class="fa-regular fa-user" style="margin-right:5px;"></i>{{ __('messages.col_client', [], 'Cliente') }}
                    </th>
                    <th style="padding:12px 18px;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:rgba(255,255,255,.45);background:rgba(212,175,55,.07);border-bottom:1px solid rgba(212,175,55,.15);">
                        <i class="fa-solid fa-scissors" style="margin-right:5px;"></i>{{ __('messages.col_service', [], 'Prestation') }}
                    </th>
                    <th style="padding:12px 18px;font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:rgba(255,255,255,.45);background:rgba(212,175,55,.07);border-bottom:1px solid rgba(212,175,55,.15);">
                        <i class="fa-solid fa-signal" style="margin-right:5px;"></i>{{ __('messages.col_status', [], 'Statut') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($allReservations->take(20) as $r)
                @php
                    $sc3 = match($r->status) {
                        'confirmed' => ['chip-confirmed', __('messages.status_confirmed', [], 'Confirmé')],
                        'done'      => ['chip-done',      __('messages.status_done', [], 'Terminé')],
                        'cancelled' => ['chip-cancelled', __('messages.status_cancelled', [], 'Annulé')],
                        default     => ['chip-pending',   __('messages.status_pending', [], 'En attente')],
                    };
                    $isPast = $r->date->isPast();
                @endphp
                <tr style="border-bottom:1px solid rgba(255,255,255,.05);transition:background .15s;"
                    onmouseover="this.style.background='rgba(255,255,255,.02)'"
                    onmouseout="this.style.background=''">
                    <td style="padding:14px 18px;vertical-align:middle;">
                        <div style="font-weight:700;color:{{ $isPast ? 'rgba(255,255,255,.45)' : '#fff' }};font-size:.85rem;">
                            {{ $r->date->format('d/m/Y') }}
                        </div>
                        <div style="font-size:.74rem;color:rgba(255,255,255,.35);margin-top:2px;">
                            <i class="fa-regular fa-clock" style="margin-right:3px;"></i>{{ substr($r->start_time,0,5) }}
                        </div>
                    </td>
                    <td style="padding:14px 18px;vertical-align:middle;">
                        <div style="display:flex;align-items:center;gap:9px;">
                            <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,rgba(212,175,55,.25),rgba(212,175,55,.1));border:1.5px solid rgba(212,175,55,.3);display:flex;align-items:center;justify-content:center;font-size:11.5px;font-weight:800;color:#f5d06f;flex-shrink:0;text-transform:uppercase;">
                                {{ strtoupper(substr($r->client?->name ?? 'N', 0, 1)) }}
                            </div>
                            <span style="font-size:.83rem;font-weight:600;color:rgba(255,255,255,.8);">{{ $r->client?->name ?? '—' }}</span>
                        </div>
                    </td>
                    <td style="padding:14px 18px;vertical-align:middle;font-size:.83rem;color:rgba(255,255,255,.7);font-weight:600;">
                        {{ $r->service?->name ?? '—' }}
                    </td>
                    <td style="padding:14px 18px;vertical-align:middle;">
                        <span class="pl-status-chip {{ $sc3[0] }}">{{ $sc3[1] }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($allReservations->count() > 20)
    <div style="padding:14px 18px;text-align:center;">
        <a href="{{ route('employee.reservations') }}" class="emp-link" style="font-size:.82rem;">
            {{ __('messages.planning_view_more', ['count' => $allReservations->count() - 20]) }} <i class="fa-solid fa-arrow-right" style="margin-left:4px;"></i>
        </a>
    </div>
    @endif
    @endif
</div>

@endsection

