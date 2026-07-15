@extends('layouts.admin')

@section('title', __('messages.hours_title'))
@section('page-title', __('messages.hours_subtitle'))
@section('page-subtitle', __('messages.hours_hero_desc'))

@section('content')

{{-- FONT AWESOME --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

    /* ====================================
        MAIN CARD
    ==================================== */

    .schedule-card{
        border: 1px solid rgba(148,163,184,.1);
        border-radius: 30px;
        overflow: hidden;
        background: rgba(255,255,255,.04);
        backdrop-filter: blur(10px);
    }

    /* ====================================
        HEADER
    ==================================== */

    .schedule-header{
        padding: 36px;
        background:
            radial-gradient(circle at top right, rgba(212,175,55,.18), transparent 30%),
            linear-gradient(135deg,#0f172a 0%,#1a1400 100%);
        color: white;
        position: relative;
        overflow: hidden;
        border-bottom: 1px solid rgba(212,175,55,.12);
    }

    .schedule-header::before{
        content: "";
        position: absolute;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        background: rgba(212,175,55,.05);
        top: -120px;
        right: -90px;
    }

    .schedule-header::after{
        content: "";
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: rgba(212,175,55,.04);
        bottom: -90px;
        left: -60px;
    }

    .schedule-title{
        font-size: 30px;
        font-weight: 900;
        margin-bottom: 10px;
        position: relative;
        z-index: 2;
        color: #fff;
    }

    .schedule-subtitle{
        color: rgba(255,255,255,.6);
        font-size: 15px;
        line-height: 1.7;
        max-width: 700px;
        position: relative;
        z-index: 2;
    }

    .schedule-badge{
        margin-top: 22px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 18px;
        border-radius: 14px;
        background: rgba(212,175,55,.15);
        border: 1px solid rgba(212,175,55,.2);
        color: #D4AF37;
        backdrop-filter: blur(10px);
        font-weight: 700;
        font-size: 14px;
        position: relative;
        z-index: 2;
    }

    /* ====================================
        STATS
    ==================================== */

    .stats-grid{
        display: grid;
        grid-template-columns: repeat(auto-fit,minmax(220px,1fr));
        gap: 22px;
        padding: 30px;
        background: rgba(255,255,255,.03);
        border-bottom: 1px solid rgba(255,255,255,.07);
    }

    .stat-card{
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.09);
        border-radius: 22px;
        padding: 24px;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before{
        content: "";
        position: absolute;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(212,175,55,.05);
        right: -40px;
        top: -40px;
    }

    .stat-top{
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }

    .stat-icon{
        width: 62px;
        height: 62px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: #0f172a;
    }

    .icon-gold{
        background: linear-gradient(135deg,#D4AF37,#B8860B);
    }

    .icon-green{
        background: linear-gradient(135deg,#10b981,#059669);
        color: #fff;
    }

    .icon-orange{
        background: linear-gradient(135deg,#f59e0b,#ea580c);
        color: #fff;
    }

    .stat-number{
        font-size: 30px;
        font-weight: 900;
        color: rgba(255,255,255,.9);
        line-height: 1;
    }

    .stat-label{
        color: rgba(255,255,255,.45);
        font-size: 14px;
        font-weight: 600;
    }

    /* ====================================
        TABLE
    ==================================== */

    .table-wrapper{
        padding: 30px;
    }

    .schedule-table{
        margin: 0;
        border-collapse: separate;
        border-spacing: 0 12px;
        --bs-table-color: rgba(255,255,255,.8);
        --bs-table-bg: transparent;
        --bs-table-striped-bg: transparent;
        --bs-table-hover-bg: transparent;
    }

    .schedule-table thead th{
        border: none;
        background: transparent;
        color: rgba(255,255,255,.35);
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .08em;
        font-weight: 700;
        padding: 0 18px 10px;
    }

    .schedule-table tbody tr{
        background: rgba(255,255,255,.05);
        border: 1px solid rgba(255,255,255,.07);
        transition: .2s ease;
    }

    .schedule-table tbody tr:hover{
        background: rgba(255,255,255,.08);
        transform: translateY(-2px);
    }

    .schedule-table tbody td{
        padding: 20px 18px;
        vertical-align: middle;
        border-top: none;
        border-bottom: none;
        color: rgba(255,255,255,.8);
    }

    .schedule-table tbody td:first-child{
        border-top-left-radius: 16px;
        border-bottom-left-radius: 16px;
    }

    .schedule-table tbody td:last-child{
        border-top-right-radius: 16px;
        border-bottom-right-radius: 16px;
    }

    /* ====================================
        DAY INFO
    ==================================== */

    .day-info{
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .day-icon{
        width: 52px;
        height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg,#D4AF37,#B8860B);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0f172a;
        font-size: 20px;
        flex-shrink: 0;
        box-shadow: 0 8px 20px rgba(212,175,55,.25);
    }

    .day-name{
        font-size: 16px;
        font-weight: 700;
        color: rgba(255,255,255,.9);
        margin-bottom: 3px;
    }

    .day-desc{
        color: rgba(255,255,255,.35);
        font-size: 12px;
        font-weight: 500;
    }

    /* ====================================
        TIME BADGES
    ==================================== */

    .time-badge{
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 700;
    }

    .badge-open{
        background: rgba(59,130,246,.15);
        color: #93c5fd;
    }

    .badge-close-time{
        background: rgba(234,88,12,.15);
        color: #fb923c;
    }

    .badge-status{
        background: rgba(16,185,129,.15);
        color: #4ade80;
    }

    .badge-closed-status{
        background: rgba(239,68,68,.12);
        color: #f87171;
    }

    /* ====================================
        ACTION BUTTONS
    ==================================== */

    .action-btn{
        border: none;
        border-radius: 12px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 700;
        transition: .2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-edit{
        background: rgba(212,175,55,.15);
        color: #D4AF37;
        border: 1px solid rgba(212,175,55,.2);
    }

    .btn-edit:hover{
        background: rgba(212,175,55,.25);
        color: #D4AF37;
        transform: translateY(-1px);
    }

    .btn-save{
        background: linear-gradient(135deg,#D4AF37,#B8860B);
        color: #0f172a;
        font-weight: 800;
        box-shadow: 0 8px 20px rgba(212,175,55,.25);
    }

    .btn-save:hover{
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(212,175,55,.35);
    }

    /* ====================================
        EDIT FORM CARD
    ==================================== */

    .edit-card{
        background: rgba(255,255,255,.04);
        border: 1px solid rgba(212,175,55,.15);
        border-radius: 24px;
        padding: 28px;
    }

    .edit-card h4{
        color: rgba(255,255,255,.9);
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 22px;
    }

    .form-label{
        color: rgba(255,255,255,.6);
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 6px;
    }

    .form-control-dark{
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.12);
        border-radius: 12px;
        color: rgba(255,255,255,.85);
        padding: 11px 14px;
        font-size: 13.5px;
        width: 100%;
        transition: .2s ease;
        appearance: none;
        -webkit-appearance: none;
    }

    .form-control-dark:focus{
        outline: none;
        border-color: #D4AF37;
        box-shadow: 0 0 0 4px rgba(212,175,55,.1);
        background: rgba(255,255,255,.08);
    }

    .form-control-dark option{
        background: #1e293b;
        color: #fff;
    }

    .alert-success-dark{
        background: rgba(16,185,129,.1);
        border: 1px solid rgba(74,222,128,.2);
        color: #4ade80;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 18px;
        font-size: 14px;
    }

    /* ====================================
        AGENDA CALENDAR
    ==================================== */

    .agenda-section {
        padding: 30px;
        border-bottom: 1px solid rgba(255,255,255,.07);
    }

    .agenda-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .agenda-title {
        font-size: 18px;
        font-weight: 800;
        color: #fff;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .agenda-week-label {
        font-size: 13px;
        color: rgba(255,255,255,.5);
        font-weight: 500;
    }

    .agenda-nav-btns {
        display: flex;
        gap: 8px;
    }

    .agenda-nav-btn {
        background: rgba(255,255,255,.06);
        border: 1px solid rgba(255,255,255,.1);
        color: rgba(255,255,255,.7);
        border-radius: 10px;
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: .2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .agenda-nav-btn:hover {
        background: rgba(212,175,55,.15);
        border-color: rgba(212,175,55,.3);
        color: #D4AF37;
    }

    .agenda-nav-btn.today {
        background: rgba(212,175,55,.12);
        border-color: rgba(212,175,55,.2);
        color: #D4AF37;
    }

    .agenda-scroll {
        overflow-x: auto;
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,.08);
    }

    .agenda-table {
        width: 100%;
        min-width: 700px;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .agenda-table th {
        padding: 12px 8px;
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: rgba(255,255,255,.45);
        background: rgba(255,255,255,.04);
        border-bottom: 1px solid rgba(255,255,255,.08);
        white-space: nowrap;
    }

    .agenda-table th.today-col {
        color: #D4AF37;
        background: rgba(212,175,55,.08);
    }

    .agenda-table th:first-child {
        width: 64px;
        min-width: 64px;
    }

    .agenda-time-cell {
        padding: 0 8px;
        text-align: right;
        font-size: 11px;
        font-weight: 700;
        color: rgba(255,255,255,.3);
        white-space: nowrap;
        vertical-align: top;
        padding-top: 6px;
        background: rgba(255,255,255,.02);
        border-right: 1px solid rgba(255,255,255,.06);
    }

    .agenda-slot {
        height: 52px;
        border-bottom: 1px solid rgba(255,255,255,.04);
        border-right: 1px solid rgba(255,255,255,.05);
        vertical-align: top;
        padding: 3px 4px;
        position: relative;
    }

    .agenda-slot.today-col {
        background: rgba(212,175,55,.03);
    }

    .agenda-slot.has-res {
        background: rgba(220,38,38,.10);
    }

    .agenda-res-pill {
        display: block;
        background: linear-gradient(135deg, rgba(220,38,38,.85), rgba(185,28,28,.9));
        border: 1px solid rgba(255,100,100,.3);
        border-radius: 7px;
        padding: 3px 7px;
        font-size: 10.5px;
        font-weight: 700;
        color: #fff;
        line-height: 1.3;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        cursor: default;
        box-shadow: 0 2px 8px rgba(220,38,38,.3);
        margin-bottom: 2px;
        position: relative;
        z-index: 1;
    }

    .agenda-res-pill:hover {
        transform: scale(1.02);
        z-index: 5;
        white-space: normal;
        overflow: visible;
        text-overflow: unset;
        width: auto;
        min-width: 120px;
    }

    .agenda-res-pill .pill-service {
        display: block;
        opacity: .8;
        font-size: 9.5px;
        font-weight: 600;
    }

    .agenda-legend {
        display: flex;
        gap: 16px;
        margin-top: 14px;
        flex-wrap: wrap;
    }

    .agenda-legend-item {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 12px;
        color: rgba(255,255,255,.5);
    }

    .legend-dot {
        width: 12px;
        height: 12px;
        border-radius: 4px;
        flex-shrink: 0;
    }

    /* ====================================
        RESPONSIVE
    ==================================== */

    @media(max-width: 768px){
        .schedule-header{ padding: 24px; }
        .table-wrapper{ padding: 16px; }
        .agenda-section { padding: 16px; }
        .schedule-title{ font-size: 24px; }
        .action-btn{ width: 100%; justify-content: center; }
        .edit-card{ padding: 20px; }
    }

</style>

@php
    $days = [
        ['name' => 'Lundi',    'icon' => 'fa-calendar-day'],
        ['name' => 'Mardi',    'icon' => 'fa-business-time'],
        ['name' => 'Mercredi', 'icon' => 'fa-clock'],
        ['name' => 'Jeudi',    'icon' => 'fa-calendar-check'],
        ['name' => 'Vendredi', 'icon' => 'fa-star'],
        ['name' => 'Samedi',   'icon' => 'fa-crown'],
        ['name' => 'Dimanche', 'icon' => 'fa-mug-hot'],
    ];

    $openingHours    = $salon->opening_hours ?? [];
    $defaultSchedule = ['open' => '09:00', 'close' => '19:00', 'status' => 'open'];

    // ── Agenda calendar data ──
    $weekOffset        = $weekOffset ?? 0;
    $weekStart         = $weekStart  ?? now()->startOfWeek(\Carbon\Carbon::MONDAY);
    $weekEnd           = $weekEnd    ?? $weekStart->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);
    $reservationsByDate = $reservationsByDate ?? collect();
    $today             = now()->toDateString();

    // Build week days column headers
    $weekDays = [];
    for ($d = 0; $d < 7; $d++) {
        $date = $weekStart->copy()->addDays($d);
        $weekDays[] = [
            'date'    => $date->toDateString(),
            'label'   => $date->translatedFormat('D d/m'),
            'isToday' => $date->toDateString() === $today,
        ];
    }

    // Build 30-min time slots from 08:00 to 20:00
    $timeSlots = [];
    $slotStart = \Carbon\Carbon::createFromTimeString('08:00');
    $slotEnd   = \Carbon\Carbon::createFromTimeString('20:00');
    while ($slotStart < $slotEnd) {
        $timeSlots[] = $slotStart->format('H:i');
        $slotStart->addMinutes(30);
    }

    // Pre-index reservations by date → array of [slot => [res,...]]
    $agendaMap = [];
    foreach ($reservationsByDate as $dateStr => $resos) {
        foreach ($resos as $r) {
            $t    = \Carbon\Carbon::createFromTimeString(substr($r->start_time, 0, 5));
            $slot = $t->format('H') . ':' . ($t->minute >= 30 ? '30' : '00');
            $agendaMap[$dateStr][$slot][] = $r;
        }
    }
@endphp

<div class="schedule-card">

    {{-- HEADER --}}
    <div class="schedule-header">
        <div class="schedule-title">
            <i class="fa-solid fa-calendar-days me-2"></i>
            {{ __('messages.hours_subtitle') }}
        </div>
        <div class="schedule-subtitle">
            {{ __('messages.hours_hero_desc') }}
        </div>
        <div class="schedule-badge">
            <i class="fa-solid fa-clock-rotate-left"></i>
            {{ __('messages.hours_badge') }}
        </div>
    </div>

    {{-- STATS --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon icon-gold">
                    <i class="fa-solid fa-calendar-week"></i>
                </div>
                <div class="stat-number">7</div>
            </div>
            <div class="stat-label">{{ __('messages.hours_stat_days') }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon icon-green">
                    <i class="fa-solid fa-door-open"></i>
                </div>
                <div class="stat-number">09h</div>
            </div>
            <div class="stat-label">{{ __('messages.hours_stat_open') }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon icon-orange">
                    <i class="fa-solid fa-door-closed"></i>
                </div>
                <div class="stat-number">19h</div>
            </div>
            <div class="stat-label">{{ __('messages.hours_stat_close') }}</div>
        </div>

    </div>

    {{-- ═══════════════════════════════
         AGENDA CALENDAR
    ═══════════════════════════════ --}}
    <div class="agenda-section">

        {{-- Navigation semaine --}}
        <div class="agenda-nav">
            <div>
                <div class="agenda-title">
                    <i class="fa-solid fa-calendar-week" style="color:#D4AF37;"></i>
                    {{ __('messages.hours_agenda_title') }}
                </div>
                <div class="agenda-week-label">
                    Semaine du {{ $weekStart->translatedFormat('d M') }} au {{ $weekEnd->translatedFormat('d M Y') }}
                </div>
            </div>
            <div class="agenda-nav-btns">
                <a href="?week={{ $weekOffset - 1 }}" class="agenda-nav-btn">
                    <i class="fa-solid fa-chevron-left"></i> {{ __('messages.hours_prev') }}
                </a>
                <a href="?week=0" class="agenda-nav-btn today">
                    <i class="fa-solid fa-circle-dot"></i> {{ __('messages.hours_today') }}
                </a>
                <a href="?week={{ $weekOffset + 1 }}" class="agenda-nav-btn">
                    {{ __('messages.hours_next') }} <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
        </div>

        {{-- Grille agenda --}}
        <div class="agenda-scroll">
            <table class="agenda-table">
                <thead>
                    <tr>
                        <th></th>
                        @foreach($weekDays as $col)
                        <th class="{{ $col['isToday'] ? 'today-col' : '' }}">
                            {{ $col['label'] }}
                            @if($col['isToday'])
                                <span style="display:block;font-size:9px;color:#D4AF37;margin-top:2px;">{{ __('messages.hours_today') }}</span>
                            @endif
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($timeSlots as $slot)
                    <tr>
                        <td class="agenda-time-cell">{{ $slot }}</td>
                        @foreach($weekDays as $col)
                        @php
                            $cellResos = $agendaMap[$col['date']][$slot] ?? [];
                            $hasRes    = count($cellResos) > 0;
                        @endphp
                        <td class="agenda-slot {{ $col['isToday'] ? 'today-col' : '' }} {{ $hasRes ? 'has-res' : '' }}">
                            @foreach($cellResos as $r)
                            <span class="agenda-res-pill" title="{{ $r->client?->name }} · {{ $r->service?->name }} · {{ substr($r->start_time,0,5) }}">
                                {{ substr($r->client?->name ?? 'Cliente', 0, 14) }}
                                <span class="pill-service">{{ substr($r->service?->name ?? '', 0, 16) }}</span>
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
        <div class="agenda-legend">
            <div class="agenda-legend-item">
                <div class="legend-dot" style="background:rgba(220,38,38,.7);border:1px solid rgba(255,100,100,.4);"></div>
                {{ __('messages.hours_legend_open') }}
            </div>
            <div class="agenda-legend-item">
                <div class="legend-dot" style="background:rgba(212,175,55,.15);border:1px solid rgba(212,175,55,.3);"></div>
                {{ __('messages.hours_today') }}
            </div>
            <div class="agenda-legend-item">
                <i class="fa-solid fa-circle-info" style="color:rgba(255,255,255,.3);font-size:11px;"></i>
                Survolez une réservation pour voir les détails
            </div>
        </div>

    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">
        <div class="table-responsive">
            <table class="table schedule-table align-middle">
                <thead>
                    <tr>
                        <th><i class="fa-solid fa-calendar-day me-1"></i> {{ __('messages.hours_col_day') }}</th>
                        <th><i class="fa-solid fa-door-open me-1"></i> {{ __('messages.hours_col_open') }}</th>
                        <th><i class="fa-solid fa-door-closed me-1"></i> {{ __('messages.hours_col_close') }}</th>
                        <th><i class="fa-solid fa-signal me-1"></i> {{ __('messages.hours_col_status') }}</th>
                        <th class="text-end"><i class="fa-solid fa-gear me-1"></i> {{ __('messages.hours_col_actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($days as $day)
                        @php
                            $dayKey      = strtolower($day['name']);
                            $schedule    = $openingHours[$dayKey] ?? $defaultSchedule;
                            $status      = $schedule['status'] ?? 'open';
                            $statusClass = $status === 'open' ? 'badge-status' : 'badge-closed-status';
                            $statusLabel = $status === 'open' ? __('messages.hours_status_open') : __('messages.hours_status_closed');
                        @endphp
                        <tr>
                            <td style="min-width:240px;">
                                <div class="day-info">
                                    <div class="day-icon">
                                        <i class="fa-solid {{ $day['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <div class="day-name">{{ \Carbon\Carbon::create()->startOfWeek(\Carbon\Carbon::MONDAY)->addDays($loop->index)->translatedFormat('l') }}</div>
                                        <div class="day-desc">Disponibilité standard salon</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="time-badge badge-open">
                                    <i class="fa-solid fa-sun"></i>
                                    {{ $schedule['open'] }}
                                </div>
                            </td>
                            <td>
                                <div class="time-badge badge-close-time">
                                    <i class="fa-solid fa-moon"></i>
                                    {{ $schedule['close'] }}
                                </div>
                            </td>
                            <td>
                                <div class="time-badge {{ $statusClass }}">
                                    <i class="fa-solid fa-circle-check"></i>
                                    {{ $statusLabel }}
                                </div>
                            </td>
                            <td class="text-end">
                                <button
                                    type="button"
                                    class="action-btn btn-edit"
                                    onclick="editSchedule('{{ $day['name'] }}', '{{ $schedule['open'] }}', '{{ $schedule['close'] }}', '{{ $status }}')"
                                >
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    {{ __('messages.inv_btn_edit') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- EDIT FORM --}}
    <div class="table-wrapper" style="padding-top:0;">
        <div class="edit-card">

            <h4><i class="fa-solid fa-pen-to-square me-2" style="color:#D4AF37;"></i> {{ __('messages.hours_edit_title') }}</h4>

            @if(session('success'))
                <div class="alert-success-dark">
                    <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.heuresOuverture.update') }}">
                @csrf
                @method('PUT')

                <div class="row g-3 align-items-end">

                    <div class="col-md-3">
                        <label class="form-label">{{ __('messages.hours_field_day') }}</label>
                        <select name="day" id="day" class="form-control-dark">
                            @foreach($days as $day)
                                <option value="{{ $day['name'] }}">{{ $day['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">{{ __('messages.hours_field_open') }}</label>
                        <input
                            type="time"
                            name="open_time"
                            id="open_time"
                            class="form-control-dark"
                            value="09:00"
                            required
                        >
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">{{ __('messages.hours_field_close') }}</label>
                        <input
                            type="time"
                            name="close_time"
                            id="close_time"
                            class="form-control-dark"
                            value="19:00"
                            required
                        >
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">{{ __('messages.hours_col_status') }}</label>
                        <select name="status" id="status" class="form-control-dark">
                            <option value="open">{{ __('messages.hours_status_open') }}</option>
                            <option value="closed">{{ __('messages.hours_status_closed') }}</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="action-btn btn-save" style="width:100%;justify-content:center;">
                            <i class="fa-solid fa-floppy-disk"></i>
                            {{ __('messages.hours_save_btn') }}
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function editSchedule(day, openTime, closeTime, status) {
        document.getElementById('day').value       = day;
        document.getElementById('open_time').value  = openTime;
        document.getElementById('close_time').value = closeTime;
        document.getElementById('status').value    = status;
        document.getElementById('open_time').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
</script>

@endsection
