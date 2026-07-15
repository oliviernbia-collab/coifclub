@extends('layouts.employee')
@section('title', __('messages.employee_reservations'))

@section('content')

<style>
/* ─── HEADER ─── */
.page-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:28px; flex-wrap:wrap; gap:14px; }
.page-eyebrow { font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.1em; color:#ff6ab4; margin-bottom:5px; display:flex; align-items:center; gap:6px; }

/* ─── CARD ─── */
.res-card { background:rgba(255,255,255,.04); border-radius:22px; border:1px solid rgba(255,255,255,.08); box-shadow:0 4px 24px rgba(0,0,0,.25); overflow:hidden; position:relative; }
.res-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:linear-gradient(90deg,#e91e8c,#ff6ab4); }

/* ─── FILTER BAR ─── */
.filter-bar { display:flex; gap:8px; padding:16px 20px; border-bottom:1px solid rgba(255,255,255,.06); flex-wrap:wrap; align-items:center; background:rgba(255,255,255,.02); }
.filter-chip { display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:999px; font-size:12px; font-weight:700; border:1.5px solid rgba(255,255,255,.1); background:rgba(255,255,255,.04); color:rgba(255,255,255,.6); cursor:default; transition:.2s; }
.chip-all     { border-color:rgba(233,30,140,.3); background:rgba(233,30,140,.08); color:#ff6ab4; }
.chip-pending { border-color:rgba(251,191,36,.3); background:rgba(251,191,36,.08); color:#fbbf24; }
.chip-done    { border-color:rgba(74,222,128,.3);  background:rgba(74,222,128,.08); color:#4ade80; }
.chip-count { background:currentColor; color:#0e0a1c; width:18px; height:18px; border-radius:50%; display:inline-flex; align-items:center; justify-content:center; font-size:10px; font-weight:800; }

/* ─── TABLE ─── */
.res-table { width:100%; border-collapse:collapse; }
.res-table thead th { padding:12px 18px; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:rgba(255,255,255,.5); background:rgba(233,30,140,.08); border-bottom:1px solid rgba(233,30,140,.2); white-space:nowrap; }
.res-table tbody tr { border-bottom:1px solid rgba(255,255,255,.05); transition:.2s; }
.res-table tbody tr:hover { background:rgba(255,255,255,.02); }
.res-table td { padding:15px 18px; vertical-align:middle; color:rgba(255,255,255,.8); font-size:13.5px; }
.date-main { font-weight:700; color:#fff; }
.date-time { font-size:11px; color:rgba(255,255,255,.4); margin-top:2px; }

/* ─── CLIENT CELL ─── */
.client-cell { display:flex; align-items:center; gap:10px; }
.client-avatar { width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,rgba(233,30,140,.25),rgba(233,30,140,.1)); border:1.5px solid rgba(233,30,140,.3); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:800; color:#ff6ab4; flex-shrink:0; text-transform:uppercase; }
.client-name { font-weight:700; font-size:13.5px; color:#fff; }

/* ─── BADGES ─── */
.status-badge { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:999px; font-size:11.5px; font-weight:700; }
.status-badge::before { content:''; width:5px; height:5px; border-radius:50%; flex-shrink:0; }
.status-confirmed { background:rgba(37,99,235,.15); color:#60a5fa; }
.status-confirmed::before { background:#60a5fa; }
.status-done { background:rgba(74,222,128,.15); color:#4ade80; }
.status-done::before { background:#4ade80; }
.status-pending { background:rgba(251,191,36,.12); color:#fbbf24; }
.status-pending::before { background:#fbbf24; }
.status-cancelled { background:rgba(248,113,113,.12); color:#f87171; }
.status-cancelled::before { background:#f87171; }

.price-badge { display:inline-flex; align-items:center; gap:5px; background:rgba(74,222,128,.1); color:#4ade80; padding:5px 11px; border-radius:999px; font-size:12px; font-weight:800; }

/* ─── ACTIONS ─── */
.btn-done { display:inline-flex; align-items:center; gap:6px; background:linear-gradient(135deg,#16a34a,#22c55e); border:none; color:#fff; font-weight:700; padding:8px 16px; border-radius:10px; font-size:12.5px; cursor:pointer; transition:.25s; white-space:nowrap; }
.btn-done:hover { transform:translateY(-2px); box-shadow:0 8px 18px rgba(74,222,128,.25); }
.no-action { color:rgba(255,255,255,.2); font-size:12px; font-weight:600; }

/* ─── EMPTY ─── */
.empty-state { padding:70px 20px; text-align:center; }
.empty-icon { width:90px; height:90px; margin:0 auto 20px; border-radius:50%; background:linear-gradient(135deg,rgba(233,30,140,.1),rgba(233,30,140,.05)); border:2px solid rgba(233,30,140,.15); display:flex; align-items:center; justify-content:center; font-size:36px; color:#ff6ab4; }
.empty-title { font-size:20px; font-weight:800; color:#fff; margin-bottom:8px; }
.empty-text { color:rgba(255,255,255,.45); font-size:14px; }

/* ─── RESPONSIVE ─── */
@media(max-width:640px) {
    .page-header { flex-direction:column; align-items:stretch; }
    .filter-bar { flex-wrap:nowrap; overflow-x:auto; -webkit-overflow-scrolling:touch; padding:12px 16px; gap:6px; }
    .filter-bar::-webkit-scrollbar { display:none; }
    .filter-chip { flex-shrink:0; }
    .res-table thead { display:none; }
    .res-table tbody tr { display:block; margin:0 14px 14px; padding:16px; border:1px solid rgba(255,255,255,.08); border-radius:20px; box-shadow:0 4px 14px rgba(0,0,0,.2); }
    .res-table td { display:flex; justify-content:space-between; align-items:center; padding:6px 0; border:none; font-size:13px; }
    .res-table td::before { content:attr(data-label); font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.07em; color:rgba(255,255,255,.4); min-width:80px; flex-shrink:0; }
    .res-table td:first-child { margin-bottom:10px; padding-bottom:12px; border-bottom:1px solid rgba(255,255,255,.06); }
    .res-table td:first-child::before { display:none; }
    .res-table td:last-child { margin-top:8px; padding-top:12px; border-top:1px solid rgba(255,255,255,.06); justify-content:flex-start; }
    .res-table td:last-child::before { display:none; }
    .btn-done { width:100%; justify-content:center; padding:11px; font-size:13.5px; }
}
</style>

{{-- HEADER --}}
<div class="page-header">
    <div>
        <div class="page-eyebrow">
            <i class="bi bi-calendar-check"></i>
            {{ __('messages.planning_eyebrow') }}
        </div>
        <h1 class="page-title" style="-webkit-text-fill-color:#fff!important;">{{ __('messages.employee_reservations') }}</h1>
        <p class="page-subtitle mb-0">{{ __('messages.track_appointments') }}</p>
    </div>
</div>

{{-- CARD --}}
<div class="res-card">

    @if($reservations->isEmpty())

        <div class="empty-state">
            <div class="empty-icon">
                <i class="bi bi-calendar-x"></i>
            </div>
            <div class="empty-title">{{ __('messages.no_reservations_title') }}</div>
            <div class="empty-text">{{ __('messages.no_reservations_text') }}</div>
        </div>

    @else

        @php
            $total     = $reservations->count();
            $pending   = $reservations->where('status','pending')->count();
            $confirmed = $reservations->where('status','confirmed')->count();
            $done      = $reservations->where('status','done')->count();
        @endphp

        <div class="filter-bar">
            <span class="filter-chip chip-all">
                <i class="bi bi-list"></i>
                {{ __('messages.filter_all') }}
                <span class="chip-count" style="background:#e91e8c;">{{ $total }}</span>
            </span>
            @if($pending)
            <span class="filter-chip chip-pending">
                <i class="bi bi-clock"></i>
                {{ __('messages.filter_pending') }}
                <span class="chip-count">{{ $pending }}</span>
            </span>
            @endif
            @if($confirmed)
            <span class="filter-chip" style="border-color:rgba(96,165,250,.3);background:rgba(96,165,250,.08);color:#60a5fa;">
                <i class="bi bi-check-circle"></i>
                {{ __('messages.filter_confirmed') }}
                <span class="chip-count">{{ $confirmed }}</span>
            </span>
            @endif
            @if($done)
            <span class="filter-chip chip-done">
                <i class="bi bi-flag"></i>
                {{ __('messages.filter_done') }}
                <span class="chip-count">{{ $done }}</span>
            </span>
            @endif
        </div>

        <table class="res-table">
            <thead>
                <tr>
                    <th>{{ __('messages.col_date_time') }}</th>
                    <th>{{ __('messages.col_client') }}</th>
                    <th>{{ __('messages.col_service') }}</th>
                    <th>{{ __('messages.col_amount') }}</th>
                    <th>{{ __('messages.col_status') }}</th>
                    <th style="text-align:right">{{ __('messages.col_actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                <tr>
                    <td data-label="">
                        <div>
                            <div class="date-main">{{ \Carbon\Carbon::parse($reservation->date)->format('d/m/Y') }}</div>
                            <div class="date-time">
                                <i class="bi bi-clock" style="margin-right:4px;"></i>
                                {{ \Carbon\Carbon::parse($reservation->start_time)->format('H:i') }}
                            </div>
                        </div>
                    </td>

                    <td data-label="{{ __('messages.col_client') }}">
                        <div class="client-cell">
                            <div class="client-avatar">{{ strtoupper(substr($reservation->client?->name ?? 'N', 0, 2)) }}</div>
                            <span class="client-name">{{ $reservation->client?->name ?? 'N/A' }}</span>
                        </div>
                    </td>

                    <td data-label="{{ __('messages.col_service') }}">
                        <span style="font-size:13px;color:rgba(255,255,255,.8);font-weight:600;">
                            {{ $reservation->service?->name ?? 'N/A' }}
                        </span>
                    </td>

                    <td data-label="{{ __('messages.col_amount') }}">
                        <span class="price-badge">
                            <i class="bi bi-coin"></i>
                            {{ number_format($reservation->amount, 0, ',', ' ') }}
                        </span>
                    </td>

                    <td data-label="{{ __('messages.col_status') }}">
                        @php
                            $st = match($reservation->status) {
                                'confirmed'   => ['status-confirmed', __('messages.status_confirmed')],
                                'done'        => ['status-done',      __('messages.status_done')],
                                'cancelled'   => ['status-cancelled', __('messages.status_cancelled')],
                                default       => ['status-pending',   __('messages.status_pending')],
                            };
                        @endphp
                        <span class="status-badge {{ $st[0] }}">{{ $st[1] }}</span>
                    </td>

                    <td data-label="" style="text-align:right">
                        @if($reservation->status === 'confirmed')
                            <form action="{{ route('employee.reservation.done', $reservation) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-done">
                                    <i class="bi bi-check-lg"></i>
                                    {{ __('messages.btn_mark_done') }}
                                </button>
                            </form>
                        @else
                            <span class="no-action"><i class="bi bi-dash-circle"></i> —</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @endif

</div>

@endsection
