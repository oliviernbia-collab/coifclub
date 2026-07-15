@extends('layouts.admin')
@section('title', __('messages.dashboard'))
@section('page-title', __('messages.dashboard'))
@section('page-subtitle', __('messages.admin_control_panel'))

@section('content')

@php $user = auth()->user(); @endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
/* ── Reset zone contenu ───────────────── */
.adm-db * { box-sizing: border-box; }
.adm-db { font-family: 'Inter', sans-serif; }

/* ── Slideshow Hero ───────────────────── */
.adm-slideshow {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 24px;
    height: 160px;
    border: 1px solid rgba(212,175,55,.2);
}
.adm-slide {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center;
    opacity: 0;
    transition: opacity 1.2s ease;
}
.adm-slide.active { opacity: 1; }
.adm-slide-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(14,10,28,.92) 0%, rgba(26,18,48,.7) 60%, rgba(212,175,55,.14) 100%);
}
.adm-slide-content {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 26px 32px;
    z-index: 2;
}
.adm-slide-eyebrow {
    font-size: .72rem; color: rgba(255,255,255,.6);
    margin-bottom: 6px; font-weight: 500;
    text-transform: uppercase; letter-spacing: .08em;
}
.adm-slide-title {
    font-size: 1.7rem; font-weight: 800;
    color: #fff !important; -webkit-text-fill-color: #fff !important;
    margin: 0 0 4px; line-height: 1.1;
    background: none !important;
}
.adm-slide-title span {
    background: linear-gradient(135deg, #D4AF37, #f5d06f) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
}
.adm-slide-sub {
    color: rgba(255,255,255,.6); font-size: .88rem;
    margin: 0; font-weight: 500;
}
.adm-slide-dots {
    position: absolute; bottom: 14px; left: 32px;
    display: flex; gap: 6px; z-index: 3;
}
.adm-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: rgba(255,255,255,.35); transition: all .3s;
}
.adm-dot.active { background: #D4AF37; width: 18px; border-radius: 3px; }
.adm-slide-deco {
    position: absolute; right: 0; top: 0; bottom: 0;
    width: 240px; overflow: hidden; pointer-events: none; z-index: 1;
}
.adm-slide-deco-circle {
    position: absolute; right: -20px; top: -20px;
    width: 200px; height: 180px; border-radius: 50%;
    background: linear-gradient(135deg, rgba(212,175,55,.2), rgba(245,208,111,.1));
}
.adm-slide-deco i {
    position: absolute; right: 40px; top: 50%;
    transform: translateY(-50%);
    font-size: 4rem; color: rgba(212,175,55,.2);
}

/* ── Grilles ──────────────────────────── */
.adm-stats  { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
.adm-grid2  { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:20px; }
.adm-grid3  { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; margin-bottom:20px; }

/* ── Carte générique ──────────────────── */
.adm-card {
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.08);
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(0,0,0,.25);
    overflow: hidden;
}
.adm-card-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 18px 22px;
    border-bottom: 1px solid rgba(255,255,255,.06);
}
.adm-card-title {
    font-size:.95rem; font-weight:700; margin:0;
    color:#fff !important;
    -webkit-text-fill-color:#fff !important;
    background:none !important;
}
.adm-card-body  { padding: 18px 22px; }
.adm-link { font-size:.82rem; font-weight:600; color:#D4AF37 !important; text-decoration:none; }
.adm-link:hover { opacity:.8; }

/* ── Stat card ────────────────────────── */
.adm-stat {
    background: rgba(255,255,255,.05);
    border: 1px solid rgba(255,255,255,.08);
    border-radius:18px;
    padding:20px;
    display:flex;
    align-items:center;
    gap:16px;
    box-shadow:0 4px 24px rgba(0,0,0,.2);
    transition: transform .2s;
}
.adm-stat:hover { transform: translateY(-3px); }
.adm-stat-icon {
    width:52px; height:52px; border-radius:50%;
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}
.adm-stat-num  {
    font-size:1.7rem; font-weight:800; line-height:1;
    color:#fff !important;
    -webkit-text-fill-color:#fff !important;
    background:none !important;
}
.adm-stat-lbl  {
    font-size:.82rem; font-weight:600; margin-top:2px;
    color:rgba(255,255,255,.7) !important;
    -webkit-text-fill-color:rgba(255,255,255,.7) !important;
}
.adm-stat-sub  {
    font-size:.75rem;
    color:rgba(255,255,255,.4) !important;
    -webkit-text-fill-color:rgba(255,255,255,.4) !important;
}

/* ── Badges statut ────────────────────── */
.adm-status {
    display:inline-block;
    font-size:.72rem; font-weight:700;
    padding:3px 10px; border-radius:999px;
    white-space:nowrap;
}
.adm-badge {
    display:inline-flex; align-items:center; gap:5px;
    background:rgba(212,175,55,.12); color:#D4AF37 !important;
    -webkit-text-fill-color:#D4AF37 !important;
    font-size:.75rem; font-weight:700;
    padding:4px 12px; border-radius:999px;
    border:1px solid rgba(212,175,55,.2);
}

/* ── Avatar ───────────────────────────── */
.adm-avatar {
    width:42px; height:42px; border-radius:12px;
    background:linear-gradient(135deg,#6b21a8,#9333ea);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-weight:700; font-size:.85rem; flex-shrink:0;
}

/* ── Item ligne ───────────────────────── */
.adm-row {
    display:flex; justify-content:space-between; align-items:center;
    gap:12px; padding:14px 22px;
    border-bottom:1px solid rgba(255,255,255,.05);
    transition: background .15s;
}
.adm-row:last-child { border-bottom:none; }
.adm-row:hover { background:rgba(255,255,255,.03); }

/* ── Service item ─────────────────────── */
.adm-service {
    display:flex; justify-content:space-between; align-items:center;
    gap:14px; padding:12px 0;
    border-bottom:1px solid rgba(255,255,255,.05);
}
.adm-service:last-child { border-bottom:none; }
.adm-service-icon {
    width:42px; height:42px; border-radius:12px;
    background:rgba(212,175,55,.1);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
}

/* ── Action box ───────────────────────── */
.adm-pending {
    background:rgba(255,255,255,.04);
    border:1px solid rgba(255,255,255,.08);
    border-radius:14px;
    padding:14px;
    margin-bottom:12px;
    display:flex; justify-content:space-between; align-items:flex-start; gap:12px;
}
.adm-pending:last-child { margin-bottom:0; }
.adm-action-btn {
    width:38px; height:38px; border:none; border-radius:10px;
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:.85rem; cursor:pointer; transition:.2s; flex-shrink:0;
}
.adm-action-btn:hover { transform: scale(1.08); }

/* ── État vide ────────────────────────── */
.adm-empty { text-align:center; padding:32px 16px; color:rgba(255,255,255,.35) !important; -webkit-text-fill-color:rgba(255,255,255,.35) !important; }
.adm-empty i { font-size:2rem; opacity:.4; display:block; margin-bottom:10px; }

/* ── Responsive ───────────────────────── */
@media(max-width:900px) {
    .adm-stats  { grid-template-columns:repeat(2,1fr); }
    .adm-grid2  { grid-template-columns:1fr; }
    .adm-grid3  { grid-template-columns:1fr; }
}
@media(max-width:640px) {
    .adm-slide-deco   { display:none; }
    .adm-slide-content { padding:18px 20px; }
    .adm-slide-title  { font-size:1.35rem; }
    .adm-pending      { flex-wrap:wrap; }
    .adm-action-btn   { width:34px; height:34px; }
    .adm-card-head    { padding:14px 16px; }
    .adm-card-body    { padding:14px 16px; }
    .adm-row          { padding:12px 16px; }
}
@media(max-width:500px) {
    .adm-stats  { grid-template-columns:1fr 1fr; }
}
@media(max-width:400px) {
    .adm-stats        { grid-template-columns:1fr; }
    .adm-slide-content { padding:14px 16px; }
    .adm-slide-title  { font-size:1.1rem; }
    .adm-stat         { padding:14px; gap:12px; }
    .adm-stat-icon    { width:42px; height:42px; }
    .adm-stat-num     { font-size:1.35rem; }
}
</style>

<div class="adm-db">

{{-- ── Slideshow Hero ─────────────────────────────────── --}}
<div class="adm-slideshow" id="admSlideshow">

    <div class="adm-slide active" style="background-image:url('{{ asset('images/C34.jpg') }}')">
        <div class="adm-slide-overlay"></div>
        <div class="adm-slide-content">
            <div class="adm-slide-eyebrow">{{ __('messages.adm_control_center') }}</div>
            <h1 class="adm-slide-title">
                {{ __('messages.hello') }}, <span>{{ explode(' ', $user->name)[0] ?? 'Admin' }}</span>
            </h1>
            <p class="adm-slide-sub">{{ now()->locale(app()->getLocale())->isoFormat('dddd D MMMM YYYY') }}</p>
        </div>
        <div class="adm-slide-deco">
            <div class="adm-slide-deco-circle"></div>
            <i class="fa-solid fa-crown"></i>
        </div>
    </div>

    <div class="adm-slide" style="background-image:url('{{ asset('images/C44.jpg') }}')">
        <div class="adm-slide-overlay"></div>
        <div class="adm-slide-content">
            <div class="adm-slide-eyebrow">{{ __('messages.today_label') }}</div>
            <h1 class="adm-slide-title">
                {{ $stats['today_reservations'] ?? 0 }} <span>{{ __('messages.reservations') }}</span>
            </h1>
            <p class="adm-slide-sub">{{ $stats['pending_reservations'] ?? 0 }} {{ __('messages.adm_pending_label') }}</p>
        </div>
        <div class="adm-slide-deco">
            <div class="adm-slide-deco-circle"></div>
            <i class="fa-solid fa-calendar-check"></i>
        </div>
    </div>

    <div class="adm-slide" style="background-image:url('{{ asset('images/C45.jpg') }}')">
        <div class="adm-slide-overlay"></div>
        <div class="adm-slide-content">
            <div class="adm-slide-eyebrow">{{ __('messages.adm_month_revenue') }}</div>
            <h1 class="adm-slide-title">
                {{ number_format($stats['month_revenue'] ?? 0, 0, ',', ' ') }}
            </h1>
            <p class="adm-slide-sub">{{ $stats['total_clients'] ?? 0 }} {{ __('messages.clients') }} · {{ $stats['total_employees'] ?? 0 }} {{ __('messages.adm_stylists') }}</p>
        </div>
        <div class="adm-slide-deco">
            <div class="adm-slide-deco-circle"></div>
            <i class="fa-solid fa-chart-pie"></i>
        </div>
    </div>

    <div class="adm-slide-dots" id="admDots">
        <div class="adm-dot active"></div>
        <div class="adm-dot"></div>
        <div class="adm-dot"></div>
    </div>
</div>

{{-- ── Stats ─────────────────────────────────────────────── --}}
<div class="adm-stats">

    <div class="adm-stat">
        <div class="adm-stat-icon" style="background:#6b21a8;">
            <i class="fa-regular fa-calendar-check" style="color:#fff;font-size:20px;"></i>
        </div>
        <div>
            <div class="adm-stat-num">{{ $stats['today_reservations'] ?? 0 }}</div>
            <div class="adm-stat-lbl">{{ __('messages.reservations') }}</div>
            <div class="adm-stat-sub">{{ __('messages.today_label') }}</div>
        </div>
    </div>

    <div class="adm-stat">
        <div class="adm-stat-icon" style="background:#059669;">
            <i class="fa-solid fa-coins" style="color:#fff;font-size:20px;"></i>
        </div>
        <div>
            <div class="adm-stat-num" style="font-size:1.1rem;">{{ number_format($stats['month_revenue'] ?? 0, 0, ',', ' ') }}</div>
            <div class="adm-stat-lbl">{{ __('messages.adm_month_revenue') }}</div>
        </div>
    </div>

    <div class="adm-stat">
        <div class="adm-stat-icon" style="background:#2563eb;">
            <i class="fa-solid fa-users" style="color:#fff;font-size:20px;"></i>
        </div>
        <div>
            <div class="adm-stat-num">{{ $stats['total_clients'] ?? 0 }}</div>
            <div class="adm-stat-lbl">{{ __('messages.clients') }}</div>
            <div class="adm-stat-sub">{{ __('messages.adm_active') }}</div>
        </div>
    </div>

    <div class="adm-stat">
        <div class="adm-stat-icon" style="background:#6b21a8;">
            <i class="fa-solid fa-user-tie" style="color:#fff;font-size:20px;"></i>
        </div>
        <div>
            <div class="adm-stat-num">{{ $stats['total_employees'] ?? 0 }}</div>
            <div class="adm-stat-lbl">{{ __('messages.adm_stylists') }}</div>
            <div class="adm-stat-sub">{{ __('messages.adm_team') }}</div>
        </div>
    </div>

    <div class="adm-stat">
        <div class="adm-stat-icon" style="background:#dc2626;">
            <i class="fa-solid fa-ban" style="color:#fff;font-size:20px;"></i>
        </div>
        <div>
            <div class="adm-stat-num">{{ $stats['cancel_rate'] ?? 0 }}%</div>
            <div class="adm-stat-lbl">{{ __('messages.cancellations') }}</div>
            <div class="adm-stat-sub">{{ __('messages.adm_global_rate') }}</div>
        </div>
    </div>

    <div class="adm-stat">
        <div class="adm-stat-icon" style="background:#d97706;">
            <i class="fa-solid fa-gift" style="color:#fff;font-size:20px;"></i>
        </div>
        <div>
            <div class="adm-stat-num">{{ $stats['active_promotions'] ?? 0 }}</div>
            <div class="adm-stat-lbl">{{ __('messages.promotions') }}</div>
            <div class="adm-stat-sub">{{ __('messages.adm_active') }}</div>
        </div>
    </div>

    <div class="adm-stat">
        <div class="adm-stat-icon" style="background:#0891b2;">
            <i class="fa-solid fa-cash-register" style="color:#fff;font-size:20px;"></i>
        </div>
        <div>
            <div class="adm-stat-num" style="font-size:1.1rem;">{{ number_format($stats['refund_amount'] ?? 0, 0, ',', ' ') }}</div>
            <div class="adm-stat-lbl">{{ __('messages.refunds') }}</div>
        </div>
    </div>

    <div class="adm-stat">
        <div class="adm-stat-icon" style="background:#7c3aed;">
            <i class="fa-solid fa-hourglass-half" style="color:#fff;font-size:20px;"></i>
        </div>
        <div>
            <div class="adm-stat-num">{{ $stats['pending_reservations'] ?? 0 }}</div>
            <div class="adm-stat-lbl">{{ __('messages.adm_pending_label') }}</div>
            <div class="adm-stat-sub">{{ __('messages.adm_to_process') }}</div>
        </div>
    </div>

</div>

{{-- ── Chart + Réservations récentes ───────────────────── --}}
<div class="adm-grid2">

    {{-- Chart revenus --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <h3 class="adm-card-title">
                <i class="fa-solid fa-chart-column" style="color:#6b21a8;margin-right:8px;"></i>
                {{ __('messages.adm_revenue_6months') }}
            </h3>
        </div>
        <div class="adm-card-body">
            <canvas id="revenueChart" height="220"></canvas>
        </div>
    </div>

    {{-- Réservations récentes --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <h3 class="adm-card-title">
                <i class="fa-solid fa-calendar-check" style="color:#6b21a8;margin-right:8px;"></i>
                {{ __('messages.adm_recent_reservations') }}
            </h3>
            <a href="{{ route('admin.reservations') }}" class="adm-link">{{ __('messages.view_all') }}</a>
        </div>

        @forelse($recentReservations ?? [] as $r)
        <div class="adm-row">
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="adm-avatar">
                    {{ strtoupper(substr($r->client->name ?? '', 0, 1)) }}{{ strtoupper(substr(explode(' ', $r->client->name ?? '')[1] ?? '', 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:.88rem;font-weight:700;color:#fff !important;">{{ $r->client->name ?? 'Client' }}</div>
                    <div style="font-size:.75rem;color:#94a3b8 !important;margin-top:2px;">
                        {{ $r->service->name ?? 'Service' }} · {{ \Carbon\Carbon::parse($r->start_time ?? now())->format('H:i') }}
                    </div>
                </div>
            </div>
            @php
                $rc = match($r->status ?? '') {
                    'confirmed','done'  => ['bg'=>'rgba(74,222,128,.12)','txt'=>'#4ade80'],
                    'pending'           => ['bg'=>'rgba(251,191,36,.12)','txt'=>'#fbbf24'],
                    'cancelled'         => ['bg'=>'rgba(239,68,68,.12)','txt'=>'#f87171'],
                    default             => ['bg'=>'rgba(212,175,55,.12)','txt'=>'#D4AF37'],
                };
            @endphp
            <span class="adm-status" style="background:{{ $rc['bg'] }};color:{{ $rc['txt'] }};">
                {{ $r->status_label ?? $r->status }}
            </span>
        </div>
        @empty
        <div class="adm-empty">
            <i class="fa-regular fa-folder-open"></i>
            {{ __('messages.adm_no_recent_res') }}
        </div>
        @endforelse
    </div>

</div>

{{-- ── Services populaires + Actions requises ──────────── --}}
<div class="adm-grid2">

    {{-- Services populaires --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <h3 class="adm-card-title">
                <i class="fa-solid fa-fire" style="color:#6b21a8;margin-right:8px;"></i>
                {{ __('messages.adm_popular_services') }}
            </h3>
        </div>
        <div class="adm-card-body">
            @forelse($topServices ?? [] as $i => $s)
            <div class="adm-service">
                <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0;">
                    <div class="adm-service-icon">
                        <i class="fa-solid fa-scissors" style="color:#6b21a8;font-size:15px;"></i>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:.88rem;font-weight:700;color:#fff !important;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $s->name }}</div>
                        <div style="background:rgba(255,255,255,.1);border-radius:999px;height:5px;margin-top:6px;overflow:hidden;">
                            <div style="width:{{ max(20, 100 - ($i * 15)) }}%;height:100%;border-radius:999px;background:linear-gradient(90deg,#6b21a8,#9333ea);"></div>
                        </div>
                    </div>
                </div>
                <div style="font-size:.88rem;font-weight:800;color:#D4AF37 !important;flex-shrink:0;">{{ $s->formatted_price ?? '' }}</div>
            </div>
            @empty
            <div class="adm-empty">
                <i class="fa-solid fa-box-open"></i>
                {{ __('messages.adm_no_service') }}
            </div>
            @endforelse
        </div>
    </div>

    {{-- Actions requises --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <h3 class="adm-card-title">
                <i class="fa-solid fa-bolt" style="color:#6b21a8;margin-right:8px;"></i>
                {{ __('messages.adm_required_actions') }}
            </h3>
            @if(($stats['pending_reservations'] ?? 0) > 0)
            <span class="adm-badge">
                <i class="fa-solid fa-hourglass-half"></i>
                {{ $stats['pending_reservations'] }} {{ __('messages.adm_pending_label') }}
            </span>
            @endif
        </div>
        <div class="adm-card-body">
            @forelse($pendingReservations ?? [] as $r)
            <div class="adm-pending">
                <div style="flex:1;">
                    <div style="font-size:.9rem;font-weight:700;color:#fff !important;">{{ $r->client->name ?? 'Client' }}</div>
                    <div style="font-size:.78rem;color:#94a3b8 !important;margin-top:4px;">
                        <i class="fa-solid fa-scissors" style="margin-right:4px;"></i>{{ $r->service->name ?? '' }}
                    </div>
                    <div style="font-size:.78rem;color:#94a3b8 !important;margin-top:3px;">
                        <i class="fa-regular fa-calendar" style="margin-right:4px;"></i>{{ \Carbon\Carbon::parse($r->start_time ?? now())->format('d/m H:i') }}
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    <form action="{{ route('admin.reservations.confirm', $r) }}" method="POST">
                        @csrf
                        <button class="adm-action-btn" style="background:linear-gradient(135deg,#10b981,#059669);" title="Confirmer">
                            <i class="fa-solid fa-check"></i>
                        </button>
                    </form>
                    <form action="{{ route('admin.reservations.cancel', $r) }}" method="POST">
                        @csrf
                        <button class="adm-action-btn" style="background:linear-gradient(135deg,#ef4444,#dc2626);" title="Refuser">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="adm-empty">
                <i class="fa-solid fa-circle-check"></i>
                {{ __('messages.adm_no_pending') }}
            </div>
            @endforelse
        </div>
    </div>

</div>

{{-- ── Clientes fidèles + Revenus par coiffeuse ────────── --}}
<div class="adm-grid2">

    {{-- Clientes fidèles --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <h3 class="adm-card-title">
                <i class="fa-solid fa-star" style="color:#6b21a8;margin-right:8px;"></i>
                {{ __('messages.adm_loyal_clients') }}
            </h3>
            <a href="{{ route('admin.clients') }}" class="adm-link">{{ __('messages.view_all') }}</a>
        </div>
        @forelse($topClients ?? [] as $client)
        <div class="adm-row">
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="adm-avatar" style="background:linear-gradient(135deg,#e91e8c,#c0156d);">
                    {{ strtoupper(substr($client->name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-size:.88rem;font-weight:700;color:#fff !important;">{{ $client->name }}</div>
                    <div style="font-size:.75rem;color:#94a3b8 !important;margin-top:2px;">
                        <i class="fa-solid fa-calendar-days" style="margin-right:4px;"></i>
                        {{ $client->reservations_as_client_count ?? 0 }} {{ __('messages.adm_reservations_label') }}
                    </div>
                </div>
            </div>
            <span class="adm-status" style="background:rgba(212,175,55,.12);color:#D4AF37;">{{ __('messages.adm_loyal') }}</span>
        </div>
        @empty
        <div class="adm-empty">
            <i class="fa-regular fa-folder-open"></i>
            {{ __('messages.adm_no_loyal_client') }}
        </div>
        @endforelse
    </div>

    {{-- Revenus par coiffeuse --}}
    <div class="adm-card">
        <div class="adm-card-head">
            <h3 class="adm-card-title">
                <i class="fa-solid fa-user-tie" style="color:#6b21a8;margin-right:8px;"></i>
                {{ __('messages.adm_revenue_by_employee') }}
            </h3>
            <a href="{{ route('admin.employees.index') }}" class="adm-link">{{ __('messages.adm_manage_team') }}</a>
        </div>
        <div class="adm-card-body">
            @forelse($revenueByEmployee ?? [] as $row)
            <div class="adm-service">
                <div style="display:flex;align-items:center;gap:12px;flex:1;min-width:0;">
                    <div class="adm-avatar" style="background:linear-gradient(135deg,#6b21a8,#9333ea);">
                        {{ strtoupper(substr($row['employee'], 0, 1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:.88rem;font-weight:700;color:#fff !important;">{{ $row['employee'] }}</div>
                        <div style="font-size:.75rem;color:#94a3b8 !important;margin-top:2px;">
                            {{ $row['bookings'] }} {{ __('messages.adm_paid_bookings') }}
                        </div>
                    </div>
                </div>
                <div style="font-size:.88rem;font-weight:800;color:#4ade80 !important;flex-shrink:0;">
                    {{ number_format($row['revenue'], 0, ',', ' ') }}
                </div>
            </div>
            @empty
            <div class="adm-empty">
                <i class="fa-regular fa-folder-open"></i>
                {{ __('messages.adm_no_figures') }}
            </div>
            @endforelse
        </div>
    </div>

</div>

</div>{{-- /adm-db --}}

@endsection

@push('scripts')
<script>
(function () {
    const slides = document.querySelectorAll('#admSlideshow .adm-slide');
    const dots   = document.querySelectorAll('#admDots .adm-dot');
    let current  = 0;
    function goTo(n) {
        slides[current].classList.remove('active');
        dots[current].classList.remove('active');
        current = (n + slides.length) % slides.length;
        slides[current].classList.add('active');
        dots[current].classList.add('active');
    }
    setInterval(() => goTo(current + 1), 4000);
    dots.forEach((dot, i) => dot.addEventListener('click', () => goTo(i)));
})();
</script>
<script>
const ctx = document.getElementById('revenueChart');
const labels = @json($revenueChart->pluck('month') ?? []);
const data   = @json($revenueChart->pluck('revenue') ?? []);

const grad = ctx.getContext('2d').createLinearGradient(0, 0, 0, 260);
grad.addColorStop(0, 'rgba(107,33,168,.35)');
grad.addColorStop(1, 'rgba(107,33,168,.02)');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: '{{ __("messages.adm_revenue_6months") }}',
            data,
            backgroundColor: grad,
            borderColor: '#6b21a8',
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
            hoverBackgroundColor: 'rgba(107,33,168,.55)',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false },
            tooltip: { mode: 'index', intersect: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { color: '#94a3b8', font: { size: 12 } },
                grid: { color: 'rgba(148,163,184,.12)', drawBorder: false }
            },
            x: {
                ticks: { color: '#94a3b8', font: { size: 12 } },
                grid: { display: false }
            }
        }
    }
});
</script>
@endpush
