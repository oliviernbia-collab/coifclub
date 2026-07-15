@extends('layouts.admin')

@section('title', __('messages.cal_title'))
@section('page-title', __('messages.cal_title'))
@section('page-subtitle', __('messages.cal_hero_desc'))

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap');

:root{
    --cl-bg:#0b1120;
    --cl-card:#111827;
    --cl-card-2:#0f172a;
    --cl-border:rgba(255,255,255,.06);
    --cl-text:#f8fafc;
    --cl-muted:#94a3b8;
    --cl-gold:#d4af37;
    --cl-primary:#8b5cf6;
    --cl-success:#10b981;
    --cl-danger:#ef4444;
    --cl-shadow:0 25px 50px rgba(0,0,0,.35);
}

.cl-wrapper{
    font-family:'Inter',sans-serif;
    color:var(--cl-text);
}

/* =========================================================
   HERO
========================================================= */

.cl-hero{
    position:relative;
    overflow:hidden;
    border-radius:32px;
    padding:42px;
    margin-bottom:32px;
    background:
        radial-gradient(circle at top right, rgba(139,92,246,.18), transparent 35%),
        radial-gradient(circle at bottom left, rgba(212,175,55,.14), transparent 35%),
        linear-gradient(145deg,#0f172a,#020617);
    border:1px solid rgba(255,255,255,.06);
    box-shadow:var(--cl-shadow);
}

.cl-hero::before{
    content:'';
    position:absolute;
    inset:0;
    background:
        linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
    background-size:40px 40px;
    opacity:.2;
}

.cl-eyebrow{
    display:inline-flex;
    align-items:center;
    gap:10px;
    color:var(--cl-gold);
    font-size:11px;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:.22em;
    margin-bottom:18px;
}

.cl-eyebrow::before{
    content:'';
    width:40px;
    height:1px;
    background:var(--cl-gold);
}

.cl-title{
    font-family:'Playfair Display',serif;
    font-size:54px;
    line-height:1;
    font-weight:700;
    color:white;
    margin:0 0 16px;
}

.cl-subtitle{
    max-width:720px;
    color:rgba(255,255,255,.68);
    line-height:1.9;
    font-size:15px;
    margin:0;
}

.cl-date{
    margin-top:24px;
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:10px 16px;
    border-radius:14px;
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.06);
    color:#cbd5e1;
    font-size:13px;
}

/* =========================================================
   STATS
========================================================= */

.cl-stats{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:22px;
    margin-bottom:30px;
}

.cl-stat{
    position:relative;
    overflow:hidden;
    border-radius:26px;
    padding:26px;
    background:linear-gradient(180deg,var(--cl-card),var(--cl-card-2));
    border:1px solid var(--cl-border);
    box-shadow:var(--cl-shadow);
    transition:.3s ease;
}

.cl-stat:hover{
    transform:translateY(-5px);
}

.cl-stat::after{
    content:'';
    position:absolute;
    top:-80px;
    right:-80px;
    width:180px;
    height:180px;
    border-radius:50%;
    background:rgba(255,255,255,.03);
}

.cl-stat-icon{
    width:56px;
    height:56px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:20px;
    font-size:22px;
    color:var(--cl-primary);
    background:rgba(139,92,246,.12);
    border:1px solid rgba(139,92,246,.18);
}

.cl-stat-label{
    font-size:12px;
    letter-spacing:.14em;
    text-transform:uppercase;
    color:var(--cl-muted);
    margin-bottom:12px;
}

.cl-stat-value{
    font-size:40px;
    font-weight:700;
    color:white;
    line-height:1;
    margin-bottom:10px;
}

.cl-stat-desc{
    font-size:13px;
    color:#cbd5e1;
}

/* =========================================================
   GRID
========================================================= */

.cl-grid{
    display:grid;
    grid-template-columns:380px 1fr;
    gap:28px;
}

/* =========================================================
   CARD
========================================================= */

.cl-card{
    background:linear-gradient(180deg,#111827,#0b1120);
    border:1px solid var(--cl-border);
    border-radius:30px;
    overflow:hidden;
    box-shadow:var(--cl-shadow);
}

.cl-card-head{
    padding:28px;
    border-bottom:1px solid rgba(255,255,255,.05);
}

.cl-card-title{
    font-size:24px;
    font-weight:700;
    color:white;
    margin-bottom:8px;
}

.cl-card-subtitle{
    font-size:14px;
    line-height:1.7;
    color:var(--cl-muted);
}

/* =========================================================
   APPOINTMENT
========================================================= */

.cl-next{
    padding:26px;
}

.cl-next-box{
    border-radius:24px;
    padding:24px;
    background:
        linear-gradient(135deg, rgba(139,92,246,.14), rgba(212,175,55,.08));
    border:1px solid rgba(255,255,255,.06);
}

.cl-badge{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:600;
    letter-spacing:.08em;
    text-transform:uppercase;
    color:#c4b5fd;
    background:rgba(139,92,246,.14);
    border:1px solid rgba(139,92,246,.18);
    margin-bottom:18px;
}

.cl-client{
    font-size:28px;
    font-weight:700;
    color:white;
    margin-bottom:10px;
}

.cl-service{
    color:#cbd5e1;
    margin-bottom:24px;
    line-height:1.8;
}

.cl-info{
    display:flex;
    flex-direction:column;
    gap:14px;
}

.cl-info-item{
    display:flex;
    align-items:center;
    gap:14px;
    color:#e2e8f0;
    font-size:14px;
}

.cl-info-item i{
    width:38px;
    height:38px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:rgba(255,255,255,.05);
    color:var(--cl-gold);
}

/* =========================================================
   CALENDAR
========================================================= */

.cl-calendar{
    padding:28px;
}

.cl-calendar-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:28px;
}

.cl-month{
    font-size:26px;
    font-weight:700;
    color:white;
}

.cl-actions{
    display:flex;
    gap:12px;
}

.cl-btn{
    width:42px;
    height:42px;
    border:none;
    border-radius:14px;
    background:rgba(255,255,255,.05);
    color:white;
    transition:.25s ease;
}

.cl-btn:hover{
    background:rgba(139,92,246,.18);
}

.cl-days,
.cl-dates{
    display:grid;
    grid-template-columns:repeat(7,1fr);
    gap:14px;
}

.cl-day{
    text-align:center;
    font-size:12px;
    font-weight:600;
    letter-spacing:.08em;
    text-transform:uppercase;
    color:var(--cl-muted);
    padding-bottom:10px;
}

.cl-date-box{
    position:relative;
    aspect-ratio:1;
    border-radius:20px;
    background:rgba(255,255,255,.03);
    border:1px solid rgba(255,255,255,.04);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:15px;
    color:white;
    transition:.25s ease;
    cursor:pointer;
}

.cl-date-box:hover{
    transform:translateY(-3px);
    background:rgba(139,92,246,.12);
    border-color:rgba(139,92,246,.20);
}

.cl-date-active{
    background:linear-gradient(135deg,#8b5cf6,#7c3aed);
    border:none;
    box-shadow:0 15px 30px rgba(139,92,246,.28);
}

.cl-date-booked::after{
    content:'';
    position:absolute;
    bottom:10px;
    width:7px;
    height:7px;
    border-radius:50%;
    background:var(--cl-success);
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:1200px){

    .cl-stats{
        grid-template-columns:repeat(2,1fr);
    }

    .cl-grid{
        grid-template-columns:1fr;
    }
}

@media(max-width:768px){

    .cl-hero{
        padding:30px;
        border-radius:24px;
    }

    .cl-title{
        font-size:38px;
    }

    .cl-stats{
        grid-template-columns:1fr;
    }

    .cl-calendar{
        overflow:auto;
    }

    .cl-days,
    .cl-dates{
        min-width:650px;
    }
}
</style>
@endpush

@section('content')

<div class="cl-wrapper">

    {{-- HERO --}}
    <div class="cl-hero">

        <div class="cl-eyebrow">
            {{ __('messages.cal_eyebrow') }}
        </div>

        <h1 class="cl-title">
            {{ __('messages.cal_title') }}
        </h1>

        <p class="cl-subtitle">
            {{ __('messages.cal_hero_desc') }}
        </p>

        <div class="cl-date">
            <i class="bi bi-calendar3"></i>
            {{ $today->translatedFormat('l d F Y') }}
        </div>

    </div>

    {{-- STATS --}}
    <div class="cl-stats">

        <div class="cl-stat">
            <div class="cl-stat-icon">
                <i class="bi bi-calendar-check"></i>
            </div>

            <div class="cl-stat-label">
                {{ __('messages.cal_stat_appt') }}
            </div>

            <div class="cl-stat-value">
                {{ $todayReservations }}
            </div>

            <div class="cl-stat-desc">
                {{ __('messages.cal_today') }}
            </div>
        </div>

        <div class="cl-stat">
            <div class="cl-stat-icon">
                <i class="bi bi-clock-history"></i>
            </div>

            <div class="cl-stat-label">
                {{ __('messages.cal_stat_avail') }}
            </div>

            <div class="cl-stat-value">
                {{ $availableSchedules }}
            </div>

            <div class="cl-stat-desc">
                {{ __('messages.cal_available') }}
            </div>
        </div>

        <div class="cl-stat">
            <div class="cl-stat-icon">
                <i class="bi bi-people"></i>
            </div>

            <div class="cl-stat-label">
                {{ __('messages.cal_stat_staff') }}
            </div>

            <div class="cl-stat-value">
                {{ $activeEmployees }}
            </div>

            <div class="cl-stat-desc">
                {{ __('messages.cal_stat_staff') }}
            </div>
        </div>

        <div class="cl-stat">
            <div class="cl-stat-icon">
                <i class="bi bi-graph-up-arrow"></i>
            </div>

            <div class="cl-stat-label">
                {{ __('messages.cal_stat_rate') }}
            </div>

            <div class="cl-stat-value">
                {{ $occupancyRate }}%
            </div>

            <div class="cl-stat-desc">
                {{ __('messages.cal_booked') }}
            </div>
        </div>

    </div>

    {{-- CONTENT --}}
    <div class="cl-grid">

        {{-- LEFT --}}
        <div class="cl-card">

            <div class="cl-card-head">

                <div class="cl-card-title">
                    {{ __('messages.cal_next_appt') }}
                </div>

                <div class="cl-card-subtitle">
                    {{ __('messages.cal_hero_desc') }}
                </div>

            </div>

            <div class="cl-next">

                <div class="cl-next-box">

                    <div class="cl-badge">
                        <i class="bi bi-lightning-charge-fill"></i>
                        {{ $nextReservation?->status_label ?? __('messages.cal_no_appt') }}
                    </div>

                    <div class="cl-client">
                        {{ $nextReservation?->client->name ?? __('messages.cal_no_appt') }}
                    </div>

                    <div class="cl-service">
                        {{ $nextReservation?->service->name ?? __('messages.cal_no_service') }}
                    </div>

                    <div class="cl-info">

                        <div class="cl-info-item">
                            <i class="bi bi-calendar-event"></i>
                            {{ $nextReservation ? $nextReservation->date->translatedFormat('l d F Y') . ' · ' . \Carbon\Carbon::parse($nextReservation->start_time)->format('H:i') : __('messages.cal_no_appt') }}
                        </div>

                        <div class="cl-info-item">
                            <i class="bi bi-person-badge"></i>
                            {{ $nextReservation ? ($nextReservation->employee->name ?? '—') : __('messages.cal_no_staff') }}
                        </div>

                        <div class="cl-info-item">
                            <i class="bi bi-geo-alt"></i>
                            {{ $nextReservation?->salon->name ?? 'Salon non défini' }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="cl-card">

            <div class="cl-calendar">

                <div class="cl-calendar-top">

                    <div class="cl-month">
                        {{ now()->translatedFormat('F Y') }}
                    </div>

                    <div class="cl-actions">
                        <button class="cl-btn">
                            <i class="bi bi-chevron-left"></i>
                        </button>

                        <button class="cl-btn">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>

                </div>

                {{-- DAYS --}}
                <div class="cl-days">

                    <div class="cl-day">{{ __('messages.cal_day_mon') }}</div>
                    <div class="cl-day">{{ __('messages.cal_day_tue') }}</div>
                    <div class="cl-day">{{ __('messages.cal_day_wed') }}</div>
                    <div class="cl-day">{{ __('messages.cal_day_thu') }}</div>
                    <div class="cl-day">{{ __('messages.cal_day_fri') }}</div>
                    <div class="cl-day">{{ __('messages.cal_day_sat') }}</div>
                    <div class="cl-day">{{ __('messages.cal_day_sun') }}</div>

                </div>

                {{-- DATES --}}
                <div class="cl-dates">

                    @for($i = 1; $i <= 31; $i++)

                        <div class="cl-date-box
                            {{ $i == now()->day ? 'cl-date-active' : '' }}
                            {{ in_array($i,[3,5,8,11,14,18,21,24,27]) ? 'cl-date-booked' : '' }}">
                            {{ $i }}
                        </div>

                    @endfor

                </div>

            </div>

        </div>

    </div>

</div>

@endsection