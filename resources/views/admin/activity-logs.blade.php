@extends('layouts.admin')

@section('title', __('messages.log_page_title'))
@section('page-title', __('messages.log_page_title'))
@section('page-subtitle', __('messages.log_page_sub'))

@section('content')

<style>
    .log-hero{
        background:
            radial-gradient(circle at top right, rgba(212,175,55,.18), transparent 30%),
            linear-gradient(135deg,#0f172a 0%,#1a1400 100%);
        border-radius:24px;
        padding:32px;
        margin-bottom:28px;
        border:1px solid rgba(212,175,55,.12);
        display:flex;
        align-items:center;
        gap:24px;
    }

    .log-hero-icon{
        width:64px;
        height:64px;
        border-radius:18px;
        background:rgba(212,175,55,.15);
        border:1px solid rgba(212,175,55,.2);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:26px;
        color:#D4AF37;
        flex-shrink:0;
    }

    .log-hero h2{
        color:#fff;
        font-size:22px;
        font-weight:700;
        margin-bottom:4px;
    }

    .log-hero p{
        color:rgba(255,255,255,.5);
        font-size:14px;
        margin:0;
    }

    .filter-bar{
        background:rgba(255,255,255,.04);
        border:1px solid rgba(148,163,184,.1);
        border-radius:18px;
        padding:20px 24px;
        margin-bottom:24px;
        display:flex;
        gap:16px;
        flex-wrap:wrap;
        align-items:center;
    }

    .filter-bar select,
    .filter-bar input{
        background:rgba(255,255,255,.06);
        border:1px solid rgba(255,255,255,.1);
        border-radius:10px;
        color:rgba(255,255,255,.85);
        padding:9px 14px;
        font-size:13px;
        flex:1;
        min-width:160px;
    }

    .filter-bar select option{
        background:#1e293b;
    }

    .filter-bar select:focus,
    .filter-bar input:focus{
        outline:none;
        border-color:#D4AF37;
    }

    .filter-btn{
        background:linear-gradient(135deg,#D4AF37,#B8860B);
        color:#0f172a;
        font-weight:700;
        border:none;
        border-radius:10px;
        padding:9px 20px;
        font-size:13px;
        cursor:pointer;
        white-space:nowrap;
    }

    .log-table-card{
        background:rgba(255,255,255,.04);
        border:1px solid rgba(148,163,184,.1);
        border-radius:24px;
        overflow:hidden;
    }

    .log-table{
        width:100%;
        border-collapse:collapse;
        --bs-table-color:rgba(255,255,255,.8);
        --bs-table-bg:transparent;
        --bs-table-striped-bg:transparent;
        --bs-table-hover-bg:rgba(255,255,255,.03);
    }

    .log-table thead th{
        background:rgba(255,255,255,.04);
        color:rgba(255,255,255,.45);
        font-size:11px;
        font-weight:600;
        text-transform:uppercase;
        letter-spacing:.06em;
        padding:14px 20px;
        border-bottom:1px solid rgba(255,255,255,.07);
        white-space:nowrap;
    }

    .log-table tbody tr{
        border-bottom:1px solid rgba(255,255,255,.04);
        transition:.15s ease;
    }

    .log-table tbody tr:last-child{
        border-bottom:none;
    }

    .log-table tbody tr:hover{
        background:rgba(255,255,255,.03);
    }

    .log-table tbody td{
        padding:14px 20px;
        color:rgba(255,255,255,.8);
        font-size:13.5px;
        vertical-align:middle;
    }

    .action-badge{
        display:inline-flex;
        align-items:center;
        gap:5px;
        padding:4px 11px;
        border-radius:8px;
        font-size:11.5px;
        font-weight:600;
        white-space:nowrap;
    }

    .action-success{ background:rgba(16,185,129,.15); color:#4ade80; }
    .action-danger{ background:rgba(239,68,68,.15); color:#f87171; }
    .action-warning{ background:rgba(245,158,11,.15); color:#fbbf24; }
    .action-info{ background:rgba(59,130,246,.15); color:#93c5fd; }
    .action-secondary{ background:rgba(255,255,255,.08); color:rgba(255,255,255,.5); }
    .action-primary{ background:rgba(212,175,55,.12); color:#D4AF37; }

    .user-cell{
        display:flex;
        align-items:center;
        gap:10px;
    }

    .user-avatar{
        width:34px;
        height:34px;
        border-radius:10px;
        background:linear-gradient(135deg,#D4AF37,#B8860B);
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:13px;
        font-weight:700;
        color:#0f172a;
        flex-shrink:0;
    }

    .user-name{
        color:rgba(255,255,255,.9);
        font-weight:600;
        font-size:13px;
    }

    .user-role{
        color:rgba(255,255,255,.4);
        font-size:11px;
    }

    .desc-text{
        color:rgba(255,255,255,.65);
        font-size:13px;
        max-width:320px;
    }

    .date-text{
        color:rgba(255,255,255,.4);
        font-size:12px;
        white-space:nowrap;
    }

    .ip-text{
        color:rgba(255,255,255,.35);
        font-size:11.5px;
        font-family:monospace;
    }

    .empty-state{
        text-align:center;
        padding:60px 20px;
        color:rgba(255,255,255,.35);
    }

    .empty-state i{
        font-size:48px;
        margin-bottom:16px;
        opacity:.3;
    }

    /* ── Pagination Pro ── */
    .pag-wrap{
        padding:18px 24px;
        border-top:1px solid rgba(255,255,255,.06);
        display:flex;
        align-items:center;
        justify-content:space-between;
        flex-wrap:wrap;
        gap:12px;
    }

    .pag-info{
        font-size:12.5px;
        color:rgba(255,255,255,.4);
    }

    .pag-info strong{
        color:rgba(255,255,255,.75);
        font-weight:600;
    }

    .pag-controls{
        display:flex;
        align-items:center;
        gap:4px;
    }

    .pag-btn{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-width:34px;
        height:34px;
        padding:0 10px;
        border-radius:9px;
        background:rgba(255,255,255,.06);
        border:1px solid rgba(255,255,255,.08);
        color:rgba(255,255,255,.6);
        font-size:13px;
        font-weight:500;
        text-decoration:none;
        transition:.2s ease;
        white-space:nowrap;
    }

    .pag-btn:hover{
        background:rgba(212,175,55,.15);
        border-color:rgba(212,175,55,.3);
        color:#D4AF37;
        text-decoration:none;
    }

    .pag-btn.active{
        background:linear-gradient(135deg,#D4AF37,#B8860B);
        border-color:transparent;
        color:#0f172a;
        font-weight:700;
        pointer-events:none;
    }

    .pag-btn.disabled{
        opacity:.3;
        pointer-events:none;
        cursor:default;
    }

    .pag-sep{
        color:rgba(255,255,255,.25);
        font-size:13px;
        padding:0 4px;
        user-select:none;
    }

    /* ── 768 px : tablette ── */
    @media(max-width:768px){
        .log-hero{ padding:20px; gap:14px; }
        .log-hero h2{ font-size:18px; }
        .filter-bar{ flex-direction:column; gap:10px; }
        .filter-bar select,
        .filter-bar input{ min-width:100%; }
    }

    /* ── 640 px : layout carte mobile ── */
    @media(max-width:640px){
        .log-table-card{ border-radius:18px; }

        /* Cache le <thead> */
        .log-table thead{ display:none; }

        /* Transforme table → blocs */
        .log-table,
        .log-table tbody{ display:block; width:100%; }

        /* Chaque ligne = une carte */
        .log-table tbody tr{
            display:block;
            margin:0 12px 12px;
            padding:14px 16px;
            border-radius:16px;
            background:rgba(255,255,255,.04);
            border:1px solid rgba(255,255,255,.07) !important;
            border-bottom:1px solid rgba(255,255,255,.07) !important;
        }
        .log-table tbody tr:last-child{ margin-bottom:12px; }
        .log-table tbody tr:hover{ background:rgba(255,255,255,.06); }

        /* Chaque cellule = ligne label + valeur */
        .log-table tbody td{
            display:flex;
            align-items:flex-start;
            gap:10px;
            padding:6px 0;
            border:none !important;
            font-size:13px;
        }
        .log-table tbody td::before{
            content:attr(data-label);
            font-size:10px;
            font-weight:700;
            color:rgba(255,255,255,.3);
            text-transform:uppercase;
            letter-spacing:.08em;
            min-width:82px;
            flex-shrink:0;
            padding-top:2px;
        }

        /* Cache l'IP sur mobile */
        .log-table tbody td[data-label="IP"]{ display:none; }

        /* Description sans max-width fixe */
        .desc-text{ max-width:100%; }

        /* Pagination */
        .pag-info{ display:none; }
        .pag-wrap{ justify-content:center; padding:14px 12px; }

        /* Hero */
        .log-hero-icon{ width:48px; height:48px; font-size:20px; border-radius:14px; }
    }

    /* ── 420 px : très petit écran ── */
    @media(max-width:420px){
        .log-hero{ flex-direction:column; align-items:flex-start; gap:10px; padding:16px; }
        .log-table tbody tr{ margin:0 8px 10px; padding:12px; }
        .log-table tbody td::before{ min-width:70px; }
        .filter-bar{ padding:14px 16px; }
    }

    @media(max-width:540px){
        .pag-info{ display:none; }
        .pag-wrap{ justify-content:center; }
    }
</style>

{{-- Hero --}}
<div class="log-hero">
    <div class="log-hero-icon">
        <i class="fas fa-history"></i>
    </div>
    <div>
        <h2>{{ __('messages.log_page_title') }}</h2>
        <p>{{ number_format($logs->total()) }} {{ __('messages.log_hero_desc') }}</p>
    </div>
</div>

{{-- Filtres --}}
<form method="GET" action="{{ route('admin.logs') }}" class="filter-bar">
    <select name="action">
        <option value="">{{ __('messages.log_filter_all') }}</option>
        @foreach(['login','logout','register','create','update','delete','approve','reject','confirm','cancel','payment'] as $act)
            <option value="{{ $act }}" {{ request('action') === $act ? 'selected' : '' }}>
                {{ ucfirst($act) }}
            </option>
        @endforeach
    </select>

    <input
        type="text"
        name="user"
        value="{{ request('user') }}"
        placeholder="{{ __('messages.log_filter_user_ph') }}"
    >

    <input
        type="date"
        name="date"
        value="{{ request('date') }}"
    >

    <button type="submit" class="filter-btn">
        <i class="fas fa-filter me-1"></i> {{ __('messages.log_filter_btn') }}
    </button>

    @if(request()->hasAny(['action','user','date']))
        <a href="{{ route('admin.logs') }}" style="color:rgba(255,255,255,.5);font-size:13px;text-decoration:none;white-space:nowrap;">
            <i class="fas fa-times me-1"></i> {{ __('messages.log_filter_reset') }}
        </a>
    @endif
</form>

{{-- Tableau --}}
<div class="log-table-card">
    <div class="table-scroll">
    <div style="overflow-x:auto;"><table class="log-table table">
        <thead>
            <tr>
                <th>{{ __('messages.log_col_user') }}</th>
                <th>{{ __('messages.log_col_action') }}</th>
                <th>{{ __('messages.log_col_desc') }}</th>
                <th>{{ __('messages.log_col_ip') }}</th>
                <th>{{ __('messages.log_col_date') }}</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr>
                    <td data-label="{{ __('messages.log_col_user') }}">
                        <div class="user-cell">
                            <div class="user-avatar">
                                {{ strtoupper(substr($log->user->name ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <div class="user-name">{{ $log->user->name ?? __('messages.log_system') }}</div>
                                <div class="user-role">{{ $log->user->role ?? '—' }}</div>
                            </div>
                        </div>
                    </td>
                    <td data-label="{{ __('messages.log_col_action') }}">
                        <span class="action-badge action-{{ $log->actionColor() }}">
                            {{ $log->actionLabel() }}
                        </span>
                    </td>
                    <td data-label="{{ __('messages.log_col_desc') }}">
                        <div class="desc-text">{{ $log->description }}</div>
                    </td>
                    <td data-label="{{ __('messages.log_col_ip') }}">
                        <span class="ip-text">{{ $log->ip_address ?? '—' }}</span>
                    </td>
                    <td data-label="{{ __('messages.log_col_date') }}">
                        <div class="date-text">
                            {{ $log->created_at->format('d/m/Y') }}<br>
                            <span style="color:rgba(255,255,255,.25);">{{ $log->created_at->format('H:i:s') }}</span>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="fas fa-history d-block"></i>
                            <p>{{ __('messages.log_empty') }}</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table></div>
    </div>

    @if($logs->hasPages())
    @php
        $currentPage  = $logs->currentPage();
        $lastPage     = $logs->lastPage();
        $from         = $logs->firstItem();
        $to           = $logs->lastItem();
        $total        = $logs->total();

        /* Fenêtre glissante : toujours 5 pages visibles */
        $window = 2;
        $start  = max(1, $currentPage - $window);
        $end    = min($lastPage, $currentPage + $window);
        if ($currentPage - $window < 1)  $end = min($lastPage, $end + (1 - ($currentPage - $window)));
        if ($currentPage + $window > $lastPage) $start = max(1, $start - (($currentPage + $window) - $lastPage));
    @endphp
    <div class="pag-wrap">

        {{-- Info --}}
        <div class="pag-info">
            {!! __('messages.log_pag_info', ['from' => "<strong>$from</strong>", 'to' => "<strong>$to</strong>", 'total' => "<strong>" . number_format($total) . "</strong>"]) !!}
        </div>

        {{-- Contrôles --}}
        <div class="pag-controls">

            {{-- Première page --}}
            @if($currentPage > 1)
                <a href="{{ $logs->withQueryString()->url(1) }}" class="pag-btn" title="Première page">
                    <i class="fas fa-angles-left" style="font-size:11px;"></i>
                </a>
                <a href="{{ $logs->withQueryString()->previousPageUrl() }}" class="pag-btn" title="Précédent">
                    <i class="fas fa-angle-left" style="font-size:12px;"></i>
                </a>
            @else
                <span class="pag-btn disabled"><i class="fas fa-angles-left" style="font-size:11px;"></i></span>
                <span class="pag-btn disabled"><i class="fas fa-angle-left" style="font-size:12px;"></i></span>
            @endif

            {{-- Ellipse gauche --}}
            @if($start > 1)
                <a href="{{ $logs->withQueryString()->url(1) }}" class="pag-btn">1</a>
                @if($start > 2)<span class="pag-sep">…</span>@endif
            @endif

            {{-- Pages fenêtre --}}
            @for($p = $start; $p <= $end; $p++)
                <a href="{{ $logs->withQueryString()->url($p) }}"
                   class="pag-btn {{ $p === $currentPage ? 'active' : '' }}">{{ $p }}</a>
            @endfor

            {{-- Ellipse droite --}}
            @if($end < $lastPage)
                @if($end < $lastPage - 1)<span class="pag-sep">…</span>@endif
                <a href="{{ $logs->withQueryString()->url($lastPage) }}" class="pag-btn">{{ $lastPage }}</a>
            @endif

            {{-- Suivant / Dernière --}}
            @if($currentPage < $lastPage)
                <a href="{{ $logs->withQueryString()->nextPageUrl() }}" class="pag-btn" title="Suivant">
                    <i class="fas fa-angle-right" style="font-size:12px;"></i>
                </a>
                <a href="{{ $logs->withQueryString()->url($lastPage) }}" class="pag-btn" title="Dernière page">
                    <i class="fas fa-angles-right" style="font-size:11px;"></i>
                </a>
            @else
                <span class="pag-btn disabled"><i class="fas fa-angle-right" style="font-size:12px;"></i></span>
                <span class="pag-btn disabled"><i class="fas fa-angles-right" style="font-size:11px;"></i></span>
            @endif

        </div>
    </div>
    @endif
</div>

@endsection
