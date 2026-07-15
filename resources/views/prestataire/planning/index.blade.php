@extends('layouts.prestataire')
@section('title', __('messages.planning'))

@section('content')

<style>
/* ─── HEADER ─── */
.page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; flex-wrap:wrap; gap:14px; }
.page-eyebrow { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#ff6ab4; margin-bottom:5px; display:flex; align-items:center; gap:6px; }
.page-title  { font-size:26px; font-weight:800; color:#fff; margin:0; }
.page-subtitle { color:rgba(255,255,255,.45); font-size:13.5px; }

/* ─── STATS ─── */
.plan-stats { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:28px; }
@media(max-width:768px){ .plan-stats { grid-template-columns:1fr; } }

.plan-stat { border-radius:22px; padding:26px 24px; color:#fff; position:relative; overflow:hidden; min-height:130px; display:flex; flex-direction:column; justify-content:space-between; }
.plan-stat::before { content:''; position:absolute; width:120px; height:120px; border-radius:50%; background:rgba(255,255,255,.07); top:-40px; right:-40px; }
.plan-stat-label { font-size:.82rem; font-weight:600; opacity:.8; }
.plan-stat-num { font-size:2.4rem; font-weight:800; line-height:1; margin:6px 0 2px; }
.plan-stat-icon { position:absolute; right:16px; bottom:12px; font-size:3rem; opacity:.1; }
.stat-blue   { background:linear-gradient(135deg,#2563eb,#1d4ed8); }
.stat-green  { background:linear-gradient(135deg,#16a34a,#15803d); }
.stat-yellow { background:linear-gradient(135deg,#d97706,#f59e0b); }

/* ─── CARDS ─── */
.plan-card { background:rgba(255,255,255,.04); border-radius:22px; border:1px solid rgba(255,255,255,.08); box-shadow:0 4px 24px rgba(0,0,0,.25); overflow:hidden; position:relative; }
.plan-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#e91e8c,#ff6ab4); }
.plan-card-inner { padding:24px; }

/* ─── CARD HEADER ─── */
.card-hdr { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; flex-wrap:wrap; gap:12px; }
.card-hdr-title { font-size:15px; font-weight:700; color:#fff; display:flex; align-items:center; gap:8px; }
.card-hdr-sub { font-size:12px; color:rgba(255,255,255,.45); margin-top:3px; }

.btn-filter-dark { display:inline-flex; align-items:center; gap:6px; background:rgba(233,30,140,.1); border:1px solid rgba(233,30,140,.25); color:#ff6ab4; font-size:12.5px; font-weight:700; padding:8px 16px; border-radius:10px; cursor:pointer; transition:.2s; }
.btn-filter-dark:hover { background:rgba(233,30,140,.18); }

/* ─── RESERVATION ITEMS ─── */
.res-item { border-radius:16px; padding:14px 16px; border:1px solid rgba(255,255,255,.07); margin-bottom:10px; transition:.2s; background:rgba(255,255,255,.02); }
.res-item:hover { background:rgba(255,255,255,.04); transform:translateX(3px); }
.res-item-name { font-weight:700; color:#fff; font-size:13.5px; display:flex; align-items:center; gap:8px; }
.res-item-time { font-size:11.5px; color:rgba(255,255,255,.4); margin-top:3px; display:flex; align-items:center; gap:5px; }
.res-status { padding:5px 12px; border-radius:999px; font-size:11px; font-weight:700; display:inline-flex; align-items:center; gap:5px; white-space:nowrap; }
.res-confirmed { background:rgba(74,222,128,.12); color:#4ade80; }
.res-pending   { background:rgba(251,191,36,.12); color:#fbbf24; }

/* ─── EMPTY ─── */
.plan-empty { padding:60px 20px; text-align:center; }
.plan-empty-icon { width:80px; height:80px; margin:0 auto 16px; border-radius:50%; background:rgba(233,30,140,.08); border:2px solid rgba(233,30,140,.12); display:flex; align-items:center; justify-content:center; font-size:30px; color:#ff6ab4; }
.plan-empty-title { font-size:18px; font-weight:800; color:#fff; margin-bottom:8px; }
.plan-empty-text { color:rgba(255,255,255,.4); font-size:13.5px; }

/* ─── FULLCALENDAR DARK ─── */
.fc .fc-toolbar-title { color:#fff !important; font-size:18px; font-weight:700; }
.fc .fc-button { background:rgba(233,30,140,.12) !important; border:1px solid rgba(233,30,140,.25) !important; color:#ff6ab4 !important; border-radius:10px !important; font-weight:600 !important; }
.fc .fc-button:hover { background:rgba(233,30,140,.2) !important; }
.fc .fc-button-primary:not(:disabled).fc-button-active { background:linear-gradient(135deg,#e91e8c,#c0156d) !important; border-color:transparent !important; color:#fff !important; }
.fc-theme-standard td, .fc-theme-standard th { border-color:rgba(255,255,255,.06) !important; }
.fc .fc-daygrid-day-number { color:rgba(255,255,255,.7) !important; }
.fc .fc-col-header-cell-cushion { color:rgba(255,255,255,.5) !important; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.05em; }
.fc .fc-day-today { background:rgba(233,30,140,.06) !important; }
.fc .fc-daygrid-day:hover { background:rgba(255,255,255,.03) !important; }
.fc .fc-today-button { background:rgba(255,255,255,.06) !important; border:1px solid rgba(255,255,255,.1) !important; color:rgba(255,255,255,.7) !important; }
</style>

{{-- HEADER --}}
<div class="page-header">
    <div>
        <div class="page-eyebrow">
            <i class="fa-solid fa-calendar-days"></i>
            {{ __('messages.planning') }}
        </div>
        <h1 class="page-title">{{ __('messages.planning_reservations_title') }}</h1>
        <p class="page-subtitle mb-0">{{ __('messages.planning_subtitle') }}</p>
    </div>
</div>

{{-- STATS --}}
<div class="plan-stats">
    <div class="plan-stat stat-blue">
        <div class="plan-stat-label">{{ __('messages.total_reservations') }}</div>
        <div class="plan-stat-num">{{ $reservations->count() }}</div>
        <i class="fa-solid fa-calendar-check plan-stat-icon"></i>
    </div>
    <div class="plan-stat stat-green">
        <div class="plan-stat-label">{{ __('messages.confirmed_reservations') }}</div>
        <div class="plan-stat-num">{{ $reservations->where('status','confirmed')->count() }}</div>
        <i class="fa-solid fa-circle-check plan-stat-icon"></i>
    </div>
    <div class="plan-stat stat-yellow">
        <div class="plan-stat-label">{{ __('messages.filter_pending') }}</div>
        <div class="plan-stat-num">{{ $reservations->where('status','pending')->count() }}</div>
        <i class="fa-solid fa-clock plan-stat-icon"></i>
    </div>
</div>

{{-- CONTENT --}}
<div class="row g-4">

    {{-- CALENDAR --}}
    <div class="col-lg-8">
        <div class="plan-card">
            <div class="plan-card-inner">
                <div class="card-hdr">
                    <div>
                        <div class="card-hdr-title">
                            <i class="fa-solid fa-calendar-week" style="color:#ff6ab4;"></i>
                            {{ __('messages.calendar') }}
                        </div>
                        <div class="card-hdr-sub">{{ __('messages.calendar_overview') }}</div>
                    </div>
                    <button class="btn-filter-dark">
                        <i class="fa-solid fa-filter"></i>
                        {{ __('messages.btn_filter') }}
                    </button>
                </div>
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    {{-- SIDEBAR --}}
    <div class="col-lg-4">
        <div class="plan-card">
            <div class="plan-card-inner">
                <div class="card-hdr">
                    <div>
                        <div class="card-hdr-title">
                            <i class="fa-solid fa-list-check" style="color:#ff6ab4;"></i>
                            {{ __('messages.reservations') }}
                        </div>
                        <div class="card-hdr-sub">{{ __('messages.recent_appointments_list') }}</div>
                    </div>
                    <span style="background:rgba(233,30,140,.12);color:#ff6ab4;padding:4px 12px;border-radius:999px;font-size:12px;font-weight:800;">
                        {{ $reservations->count() }}
                    </span>
                </div>

                @forelse($reservations as $r)
                    <div class="res-item">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <div>
                                <div class="res-item-name">
                                    <i class="fa-solid fa-scissors" style="color:#ff6ab4;font-size:11px;"></i>
                                    {{ $r->service->nom ?? __('messages.services') }}
                                </div>
                                <div class="res-item-time">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $r->created_at->format('d/m/Y H:i') }}
                                </div>
                            </div>
                            @if($r->status == 'confirmed')
                                <span class="res-status res-confirmed">
                                    <i class="fa-solid fa-circle-check"></i>{{ __('messages.status_confirmed') }}
                                </span>
                            @else
                                <span class="res-status res-pending">
                                    <i class="fa-solid fa-hourglass-half"></i>{{ __('messages.status_pending') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="plan-empty">
                        <div class="plan-empty-icon">
                            <i class="fa-regular fa-calendar-xmark"></i>
                        </div>
                        <div class="plan-empty-title">{{ __('messages.no_reservations_title') }}</div>
                        <div class="plan-empty-text">{{ __('messages.no_reservations_text') }}</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

{{-- FULLCALENDAR --}}
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        height: 650,
        locale: '{{ app()->getLocale() }}',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: @json($events),
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            meridiem: false
        }
    });
    calendar.render();
});
</script>

@endsection
