@extends('layouts.admin')
@section('title', __('messages.adm_reservations_title'))

@section('content')

<style>
    /* ===== HEADER ===== */
    .page-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 28px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .page-eyebrow {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #ff4d6d;
        margin-bottom: 5px;
    }

    .page-header h1 {
        font-size: 26px;
        font-weight: 700;
        color: var(--text, #111827);
        margin: 0;
    }

    .page-header p {
        font-size: 14px;
        color: #9ca3af;
        margin: 4px 0 0;
    }

    .btn-today {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 10px 18px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.13);
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text, #374151);
        text-decoration: none;
        transition: background 0.15s;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-today:hover {
        background: rgba(255,255,255,0.11);
        color: var(--text, #374151);
        text-decoration: none;
    }

    .btn-today svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2.2;
        flex-shrink: 0;
    }

    /* ===== STATS GRID ===== */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
        margin-bottom: 24px;
    }

    .stat-link {
        background: rgba(255,255,255,0.05);
        border: 1.5px solid rgba(255,255,255,0.09);
        border-radius: 14px;
        padding: 16px 18px;
        text-decoration: none;
        display: block;
        transition: transform 0.18s, border-color 0.18s, box-shadow 0.18s;
    }

    .stat-link:hover {
        transform: translateY(-2px);
        text-decoration: none;
    }

    .stat-link.active-filter {
        border-color: currentColor;
        box-shadow: 0 4px 16px rgba(0,0,0,0.10);
    }

    .stat-link .stat-num {
        font-size: 24px;
        font-weight: 700;
        line-height: 1;
        margin-bottom: 4px;
    }

    .stat-link .stat-lbl {
        font-size: 11px;
        font-weight: 600;
        opacity: 0.80;
    }

    .s-pending  { color: #f59e0b; }
    .s-confirmed{ color: #3b82f6; }
    .s-progress { color: #8b5cf6; }
    .s-done     { color: #10b981; }
    .s-cancelled{ color: #ef4444; }

    /* ===== FILTER BAR ===== */
    .filter-bar {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.09);
        border-radius: 14px;
        padding: 16px 20px;
        margin-bottom: 24px;
        display: flex;
        gap: 14px;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #6b7280;
    }

    .filter-control {
        padding: 9px 13px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.13);
        border-radius: 9px;
        color: var(--text, #111827);
        font-size: 13px;
        min-width: 150px;
        cursor: pointer;
    }

    .filter-control:focus {
        outline: none;
        border-color: #ff4d6d;
        box-shadow: 0 0 0 3px rgba(255,77,109,0.10);
    }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 14px;
        background: rgba(239,68,68,0.07);
        border: 1px solid rgba(239,68,68,0.16);
        border-radius: 9px;
        color: #ef4444;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.15s;
        white-space: nowrap;
        align-self: flex-end;
    }

    .btn-reset:hover {
        background: rgba(239,68,68,0.14);
        color: #ef4444;
        text-decoration: none;
    }

    /* ===== TABLE CARD ===== */
    .table-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.09);
        border-radius: 18px;
        overflow: hidden;
    }

    .table-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px 14px;
        border-bottom: 1px solid rgba(255,255,255,0.07);
        flex-wrap: wrap;
        gap: 12px;
    }

    .table-card-header h2 {
        font-size: 15px;
        font-weight: 700;
        color: var(--text, #111827);
        margin: 0;
    }

    .search-box {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 10px;
        padding: 8px 14px;
        min-width: 230px;
    }

    .search-box svg {
        width: 14px;
        height: 14px;
        stroke: #6b7280;
        stroke-width: 2;
        flex-shrink: 0;
    }

    .search-box input {
        background: transparent;
        border: none;
        outline: none;
        color: var(--text, #111827);
        font-size: 13px;
        width: 100%;
    }

    .search-box input::placeholder { color: #6b7280; }

    /* ===== TABLE ===== */
    .res-table {
        width: 100%;
        border-collapse: collapse;
    }

    .res-table thead th {
        padding: 10px 18px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #6b7280;
        white-space: nowrap;
        background: rgba(255,255,255,0.02);
        border-bottom: 1px solid rgba(255,255,255,0.07);
    }

    .res-table tbody tr {
        border-bottom: 1px solid rgba(255,255,255,0.05);
        transition: background 0.15s;
    }

    .res-table tbody tr:last-child { border-bottom: none; }
    .res-table tbody tr:hover { background: rgba(255,255,255,0.03); }

    .res-table td {
        padding: 13px 18px;
        font-size: 13px;
        color: var(--text, #111827);
        vertical-align: middle;
    }

    /* ===== REF ===== */
    .ref-code {
        font-size: 11px;
        font-weight: 600;
        color: #9ca3af;
        font-variant-numeric: tabular-nums;
        background: rgba(255,255,255,0.05);
        padding: 3px 8px;
        border-radius: 5px;
        white-space: nowrap;
    }

    /* ===== CLIENT ===== */
    .client-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .avatar-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(255,77,109,0.18), rgba(255,117,143,0.10));
        border: 1.5px solid rgba(255,77,109,0.20);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        color: #ff4d6d;
        flex-shrink: 0;
        text-transform: uppercase;
    }

    .client-name {
        font-weight: 600;
        font-size: 13px;
        color: var(--text, #111827);
    }

    .client-phone {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 1px;
    }

    /* ===== SERVICE ===== */
    .service-tag {
        display: inline-block;
        padding: 4px 10px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.10);
        border-radius: 7px;
        font-size: 12px;
        font-weight: 500;
        color: var(--text, #374151);
        white-space: nowrap;
        max-width: 140px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* ===== DATE ===== */
    .date-main {
        font-size: 13px;
        font-weight: 600;
        color: var(--text, #111827);
    }

    .date-time {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 2px;
        font-variant-numeric: tabular-nums;
    }

    /* ===== AMOUNT ===== */
    .amount {
        font-size: 14px;
        font-weight: 700;
        color: #ff4d6d;
        white-space: nowrap;
    }

    /* ===== PAYMENT ===== */
    .pay-method {
        font-size: 11px;
        color: #9ca3af;
    }

    .pay-badge {
        display: inline-block;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 5px;
        margin-top: 2px;
    }

    .pay-done {
        background: rgba(16,185,129,0.10);
        color: #10b981;
    }

    .pay-pending {
        background: rgba(245,158,11,0.10);
        color: #f59e0b;
    }

    /* ===== STATUS BADGES ===== */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-badge::before {
        content: '';
        width: 5px;
        height: 5px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .sb-pending   { background: rgba(245,158,11,0.10);  color: #f59e0b; }
    .sb-pending::before   { background: #f59e0b; }

    .sb-confirmed { background: rgba(59,130,246,0.10);  color: #3b82f6; }
    .sb-confirmed::before { background: #3b82f6; }

    .sb-progress  { background: rgba(139,92,246,0.10);  color: #8b5cf6; }
    .sb-progress::before  { background: #8b5cf6; }

    .sb-done      { background: rgba(16,185,129,0.10);  color: #10b981; }
    .sb-done::before      { background: #10b981; }

    .sb-cancelled { background: rgba(239,68,68,0.09);   color: #ef4444; }
    .sb-cancelled::before { background: #ef4444; }

    /* ===== ACTION BUTTONS ===== */
    .action-cell {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
    }

    .btn-confirm {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: rgba(16,185,129,0.08);
        border: 1px solid rgba(16,185,129,0.18);
        border-radius: 8px;
        color: #10b981;
        cursor: pointer;
        transition: background 0.15s;
        flex-shrink: 0;
    }

    .btn-confirm:hover { background: rgba(16,185,129,0.16); }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        background: rgba(239,68,68,0.07);
        border: 1px solid rgba(239,68,68,0.16);
        border-radius: 8px;
        color: #ef4444;
        cursor: pointer;
        transition: background 0.15s;
        flex-shrink: 0;
    }

    .btn-cancel:hover { background: rgba(239,68,68,0.14); }

    .btn-confirm svg, .btn-cancel svg {
        width: 14px;
        height: 14px;
        stroke: currentColor;
        stroke-width: 2.5;
    }

    .confirmed-label {
        font-size: 11px;
        font-weight: 600;
        color: #10b981;
        white-space: nowrap;
    }

    /* ===== EMPTY ===== */
    .empty-state {
        text-align: center;
        padding: 64px 24px;
    }

    .empty-icon {
        font-size: 44px;
        opacity: 0.35;
        display: block;
        margin-bottom: 12px;
    }

    .empty-state h3 {
        font-size: 15px;
        font-weight: 600;
        color: var(--text, #111827);
        margin: 0 0 6px;
    }

    .empty-state p {
        font-size: 13px;
        color: #6b7280;
        margin: 0;
    }

    /* ===== PAGINATION ===== */
   .pg-wrap{display:flex;justify-content:space-between;align-items:center;padding:14px 22px;border-top:1px solid var(--border);}
.pg-info{font-size:12px;color:var(--t3);}
.pg-btns{display:flex;gap:4px;}
.pgb{width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;border-radius:var(--rs);background:transparent;border:1px solid var(--border);color:var(--t2);font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;transition:all .15s;}
.pgb:hover:not(:disabled){background:rgba(255,255,255,0.05);color:var(--text);}
.pgb.cur{background:var(--gold);color:#111;border-color:var(--gold);}
.pgb:disabled{opacity:.3;cursor:not-allowed;}

    /* ===== MODAL ===== */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.55);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }

    .modal-box {
        background: #1c1c1e;
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 18px;
        padding: 28px 32px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 24px 60px rgba(0,0,0,0.40);
    }

    .modal-icon {
        width: 48px;
        height: 48px;
        background: rgba(239,68,68,0.10);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
    }

    .modal-icon svg {
        width: 22px;
        height: 22px;
        stroke: #ef4444;
        stroke-width: 2;
    }

    .modal-title {
        font-size: 17px;
        font-weight: 700;
        color: var(--text, #111827);
        margin: 0 0 6px;
    }

    .modal-sub {
        font-size: 13px;
        color: #9ca3af;
        margin: 0 0 20px;
    }

    .modal-label {
        font-size: 12px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        display: block;
        margin-bottom: 6px;
    }

    .modal-textarea {
        width: 100%;
        padding: 11px 14px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.13);
        border-radius: 10px;
        color: var(--text, #111827);
        font-size: 13px;
        resize: vertical;
        min-height: 80px;
        box-sizing: border-box;
    }

    .modal-textarea:focus {
        outline: none;
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239,68,68,0.10);
    }

    .modal-footer {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-modal-confirm {
        flex: 1;
        padding: 11px;
        background: linear-gradient(135deg, #ef4444, #f87171);
        border: none;
        border-radius: 10px;
        color: #fff;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: opacity 0.15s;
    }

    .btn-modal-confirm:hover { opacity: 0.88; }

    .btn-modal-cancel {
        flex: 1;
        padding: 11px;
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.13);
        border-radius: 10px;
        color: var(--text, #374151);
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s;
    }

    /* ===== TABLE RESPONSIVE ===== */
.table-responsive{
    width:100%;
    overflow-x:auto;
    overflow-y:hidden;
    -webkit-overflow-scrolling:touch;
    scrollbar-width:thin;
    scrollbar-color:rgba(255,255,255,.18) transparent;
}

.table-responsive::-webkit-scrollbar{
    height:8px;
}

.table-responsive::-webkit-scrollbar-track{
    background:transparent;
}

.table-responsive::-webkit-scrollbar-thumb{
    background:rgba(255,255,255,.15);
    border-radius:999px;
}

.res-table{
    width:100%;
    min-width:1200px;
    border-collapse:collapse;
}

    .btn-modal-cancel:hover { background: rgba(255,255,255,0.10); }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 1100px) {
        .stats-row { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 768px) {
        .page-header { flex-direction: column; align-items: stretch; gap: 14px; }
        .page-header h1 { font-size: 20px; }
        .btn-today { align-self: flex-start; }

        /* Stats 2×2 + last solo */
        .stats-row { grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .stat-link { padding: 12px 14px; }
        .stat-link .stat-num { font-size: 20px; }
        .stat-link .stat-lbl { font-size: 10px; }

        /* Filters empilés */
        .table-card-header { flex-direction: column; align-items: stretch; padding: 14px 16px; }
        .search-box { min-width: 0; width: 100%; }
        .filter-bar { flex-direction: column; gap: 10px; padding: 14px 16px; }
        .filter-control { min-width: 0; width: 100%; }
        .filter-group { width: 100%; }

        /* Scroll hint sur mobile */
        .table-responsive { padding-bottom: 6px; }
        .table-responsive::after {
            content: '← Faites défiler →';
            display: block;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            padding: 6px;
            letter-spacing: .05em;
        }

        /* Pagination centrée */
        .pg-wrap { flex-direction: column; align-items: center; gap: 10px; padding: 14px 16px; }
        .pg-info { text-align: center; }
    }

    @media (max-width: 480px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
        .stat-link:last-child { grid-column: span 2; }
        .stat-link { padding: 10px 12px; }
    }
</style>

{{-- HEADER --}}
<div class="page-header">
    <div>
        <div class="page-eyebrow">{{ __('messages.adm_agenda_badge') }}</div>
        <h1>{{ __('messages.adm_reservations_title') }}</h1>
        <p>{{ $reservations->total() }} {{ __('messages.adm_res_count_total') }}</p>
    </div>
    <a href="{{ route('admin.reservations', ['date' => now()->toDateString()]) }}" class="btn-today">
        <svg viewBox="0 0 24 24" fill="none">
            <rect x="3" y="4" width="18" height="18" rx="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M16 2v4M8 2v4M3 10h18" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        {{ __('messages.adm_today_btn') }}
    </a>
</div>

{{-- STATS --}}
@php
    $allRes = \App\Models\Reservation::query();
    if(isset($salon) && $salon) $allRes->where('salon_id', $salon->id);
@endphp

<div class="stats-row">
    @foreach([
        ['label'=> __('messages.adm_pending_res'),    'status'=>'pending',     'cls'=>'s-pending'],
        ['label'=> __('messages.adm_confirmed_res'),  'status'=>'confirmed',   'cls'=>'s-confirmed'],
        ['label'=> __('messages.adm_res_in_progress'),'status'=>'in_progress', 'cls'=>'s-progress'],
        ['label'=> __('messages.adm_res_done'),       'status'=>'done',        'cls'=>'s-done'],
        ['label'=> __('messages.adm_cancelled_res'),  'status'=>'cancelled',   'cls'=>'s-cancelled'],
    ] as $s)
    <a href="{{ route('admin.reservations', array_merge(request()->except('page'), ['status' => $s['status']])) }}"
       class="stat-link {{ $s['cls'] }} {{ request('status') === $s['status'] ? 'active-filter' : '' }}">
        <div class="stat-num">{{ (clone $allRes)->where('status', $s['status'])->count() }}</div>
        <div class="stat-lbl">{{ $s['label'] }}</div>
    </a>
    @endforeach
</div>

{{-- FILTRES --}}
<form method="GET" class="filter-bar">
    <div class="filter-group">
        <span class="filter-label">{{ __('messages.adm_filter_status') }}</span>
        <select name="status" class="filter-control" onchange="this.form.submit()">
            <option value="">{{ __('messages.adm_filter_all_statuses') }}</option>
            @foreach([
                'pending'     => __('messages.adm_res_status_pending'),
                'confirmed'   => __('messages.adm_res_status_confirmed'),
                'in_progress' => __('messages.adm_res_status_in_progress'),
                'done'        => __('messages.adm_res_status_done'),
                'cancelled'   => __('messages.adm_res_status_cancelled'),
            ] as $val => $label)
                <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="filter-group">
        <span class="filter-label">{{ __('messages.adm_filter_date') }}</span>
        <input type="date" name="date" class="filter-control" value="{{ request('date') }}" onchange="this.form.submit()">
    </div>

    <div class="filter-group">
        <span class="filter-label">{{ __('messages.adm_filter_stylist') }}</span>
        <select name="employee" class="filter-control" onchange="this.form.submit()">
            <option value="">{{ __('messages.adm_filter_all_stylists') }}</option>
            @foreach($employees ?? collect() as $e)
                <option value="{{ $e->id }}" {{ request('employee') == $e->id ? 'selected' : '' }}>
                    {{ $e->user->name }}
                </option>
            @endforeach
        </select>
    </div>

    @if(request()->anyFilled(['status','date','employee']))
        <a href="{{ route('admin.reservations') }}" class="btn-reset">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <path d="M18 6L6 18M6 6l12 12"/>
            </svg>
            {{ __('messages.adm_filter_reset') }}
        </a>
    @endif
</form>

{{-- TABLE --}}
<div class="table-card">

    <div class="table-card-header">
        <h2>{{ __('messages.adm_res_list_title') }}</h2>
        <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none"><circle cx="11" cy="11" r="7"/><path d="M21 21l-4.35-4.35" stroke-linecap="round"/></svg>
            <input type="text" id="searchInput" placeholder="{{ __('messages.adm_search_res_ph') }}">
        </div>
    </div>

    {{-- <table class="res-table" id="resTable"> --}}
        <div class="table-responsive">
    <table class="res-table" id="resTable">
        <thead>
            <tr>
                <th>{{ __('messages.adm_col_ref') }}</th>
                <th>{{ __('messages.adm_col_client') }}</th>
                <th>{{ __('messages.adm_col_service') }}</th>
                <th>{{ __('messages.adm_col_stylist') }}</th>
                <th>{{ __('messages.adm_col_datetime') }}</th>
                <th>{{ __('messages.adm_col_amount') }}</th>
                <th>{{ __('messages.adm_col_payment') }}</th>
                <th>{{ __('messages.adm_col_status') }}</th>
                <th style="text-align:right">{{ __('messages.adm_col_actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $r)
            <tr>
                {{-- REF --}}
                <td><span class="ref-code">{{ $r->reference }}</span></td>

                {{-- CLIENT --}}
                <td>
                    <div class="client-cell">
                        <div class="avatar-circle">
                            {{ strtoupper(substr($r->client->name, 0, 1)) }}{{ strtoupper(substr(explode(' ', $r->client->name)[1] ?? '', 0, 1)) }}
                        </div>
                        <div>
                            <div class="client-name">{{ $r->client->name }}</div>
                            <div class="client-phone">{{ $r->client->phone ?? '' }}</div>
                        </div>
                    </div>
                </td>

                {{-- SERVICE --}}
                <td><span class="service-tag" title="{{ $r->service?->name ?? '—' }}">{{ $r->service?->name ?? '—' }}</span></td>

                {{-- COIFFEUSE --}}
                <td style="font-size:13px;color:#9ca3af;">{{ $r->employee?->user?->name ?? '—' }}</td>

                {{-- DATE --}}
                <td>
                    <div class="date-main">{{ \Carbon\Carbon::parse($r->date)->format('d/m/Y') }}</div>
                    <div class="date-time">
                        {{ \Carbon\Carbon::parse($r->start_time)->format('H:i') }}
                        –
                        {{ \Carbon\Carbon::parse($r->end_time)->format('H:i') }}
                    </div>
                </td>

                {{-- MONTANT --}}
                <td><span class="amount">{{ $r->formatted_amount }}</span></td>

                {{-- PAIEMENT --}}
                <td>
                    @if($r->payment)
                        <div class="pay-method">{{ $r->payment->method_label }}</div>
                        <span class="pay-badge {{ $r->payment->status === 'completed' ? 'pay-done' : 'pay-pending' }}">
                            {{ $r->payment->status === 'completed' ? __('messages.adm_payment_paid') : __('messages.adm_payment_pending') }}
                        </span>
                    @else
                        <span style="font-size:12px;color:#6b7280;">—</span>
                    @endif
                </td>

                {{-- STATUT --}}
                <td>
                    @php
                        $statusMap = [
                            'pending'     => ['cls'=>'sb-pending',   'label'=> __('messages.adm_res_status_pending')],
                            'confirmed'   => ['cls'=>'sb-confirmed', 'label'=> __('messages.adm_res_status_confirmed')],
                            'in_progress' => ['cls'=>'sb-progress',  'label'=> __('messages.adm_res_status_in_progress')],
                            'done'        => ['cls'=>'sb-done',      'label'=> __('messages.adm_res_status_done')],
                            'cancelled'   => ['cls'=>'sb-cancelled', 'label'=> __('messages.adm_res_status_cancelled')],
                        ];
                        $st = $statusMap[$r->status] ?? ['cls'=>'sb-pending','label'=>$r->status];
                    @endphp
                    <span class="status-badge {{ $st['cls'] }}">{{ $st['label'] }}</span>
                </td>

                {{-- ACTIONS --}}
                <td>
                    <div class="action-cell">
                        @if($r->isPending())
                            <form action="{{ route('admin.reservations.confirm', $r) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-confirm" title="Confirmer">
                                    <svg viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                            </form>
                            <button type="button" class="btn-cancel" title="Refuser" onclick="openCancelModal({{ $r->id }})">
                                <svg viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6l12 12" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        @elseif($r->isConfirmed())
                            <span class="confirmed-label">{{ __('messages.adm_confirmed_label') }}</span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9">
                    <div class="empty-state">
                        <span class="empty-icon">📋</span>
                        <h3>{{ __('messages.adm_no_reservations') }}</h3>
                        <p>{{ __('messages.adm_no_reservations_text') }}</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pg-wrap">
        <div class="pg-info">
            {{ __('messages.adm_pagination_info', ['first' => $reservations->firstItem() ?? 0, 'last' => $reservations->lastItem() ?? 0, 'total' => $reservations->total()]) }}
        </div>

        <div class="pg-btns">
            @if ($reservations->onFirstPage())
                <button class="pgb" disabled>‹</button>
            @else
                <a href="{{ $reservations->previousPageUrl() }}" class="pgb">‹</a>
            @endif

            @php
                $start = max(1, $reservations->currentPage() - 2);
                $end = min($reservations->lastPage(), $reservations->currentPage() + 2);
            @endphp

            @if ($start > 1)
                <a href="{{ $reservations->url(1) }}" class="pgb">1</a>
                @if ($start > 2)
                    <span class="pgb" style="cursor:default;border-color:transparent;background:transparent;color:var(--t2);">…</span>
                @endif
            @endif

            @for ($page = $start; $page <= $end; $page++)
                <a href="{{ $reservations->url($page) }}" class="pgb{{ $reservations->currentPage() === $page ? ' cur' : '' }}">{{ $page }}</a>
            @endfor

            @if ($end < $reservations->lastPage())
                @if ($end < $reservations->lastPage() - 1)
                    <span class="pgb" style="cursor:default;border-color:transparent;background:transparent;color:var(--t2);">…</span>
                @endif
                <a href="{{ $reservations->url($reservations->lastPage()) }}" class="pgb">{{ $reservations->lastPage() }}</a>
            @endif

            @if ($reservations->hasMorePages())
                <a href="{{ $reservations->nextPageUrl() }}" class="pgb">›</a>
            @else
                <button class="pgb" disabled>›</button>
            @endif
        </div>
    </div>

</div>

{{-- MODAL ANNULATION --}}
<div id="cancelModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-icon">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M12 9v4M12 17h.01" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h2 class="modal-title">{{ __('messages.adm_res_reject_title') }}</h2>
        <p class="modal-sub">{{ __('messages.adm_res_reject_sub') }}</p>

        <form id="cancelForm" method="POST">
            @csrf
            <label class="modal-label">{{ __('messages.adm_res_reject_reason_label') }}</label>
            <textarea name="reason" class="modal-textarea"
                      placeholder="{{ __('messages.adm_res_reject_reason_ph') }}"></textarea>

            <div class="modal-footer">
                <button type="submit" class="btn-modal-confirm">{{ __('messages.adm_res_reject_confirm') }}</button>
                <button type="button" class="btn-modal-cancel" onclick="closeCancelModal()">{{ __('messages.btn_cancel') }}</button>
            </div>
        </form>

            {{-- MODAL SUPPRESSION --}}
<div id="deleteModal" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-icon" style="background:rgba(239,68,68,0.10);">
            <svg viewBox="0 0 24 24" fill="none" width="22" height="22" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                <path d="M10 11v6M14 11v6"/>
                <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
            </svg>
        </div>
        <h2 class="modal-title">{{ __('messages.adm_res_delete_title') }}</h2>
        <p class="modal-sub">
            <span id="deleteRef" style="color:#ef4444;font-weight:700;"></span>
            {{ __('messages.adm_res_delete_sub', ['ref' => '']) }}
        </p>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-footer">
                <button type="submit" class="btn-modal-confirm">{{ __('messages.adm_res_delete_confirm') }}</button>
                <button type="button" class="btn-modal-cancel" onclick="closeDeleteModal()">{{ __('messages.btn_cancel') }}</button>
            </div>
        </form>
    </div>
</div>
    </div>
</div>

<script>
    // MODAL
    function openCancelModal(id) {
        document.getElementById('cancelForm').action = `/admin/reservations/${id}/cancel`;
        document.getElementById('cancelModal').style.display = 'flex';
    }

    function closeCancelModal() {
        document.getElementById('cancelModal').style.display = 'none';
    }

    document.getElementById('cancelModal').addEventListener('click', function(e) {
        if (e.target === this) closeCancelModal();
    });

    // RECHERCHE
    document.getElementById('searchInput').addEventListener('input', function () {
        const val = this.value.toLowerCase();
        document.querySelectorAll('#resTable tbody tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(val) ? '' : 'none';
        });
    });
</script>

@endsection