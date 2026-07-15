${{-- @extends('layouts.admin')
@section('title', 'Rapports')
@section('page-title', 'Rapports et analytics')
@section('page-subtitle', 'Analysez les performances du salon et les revenus')

@section('content')
<div class="admin-card">
    <h3>Rapports</h3>
    <div class="row mt-4 gx-4 gy-4">
        <div class="col-lg-4">
            <div class="p-4" style="border-radius:18px;background:rgba(255,255,255,0.04);border:1px solid rgba(148,163,184,0.12);">
                <h5>Revenu total</h5>
                <p class="fs-4 mb-0">{{ number_format($totalRevenue ?? 0, 0, ',', ' ') }}</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="p-4" style="border-radius:18px;background:rgba(255,255,255,0.04);border:1px solid rgba(148,163,184,0.12);">
                <h5>Reservations</h5>
                <p class="fs-4 mb-0">{{ $reservationCount ?? 0 }}</p>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="p-4" style="border-radius:18px;background:rgba(255,255,255,0.04);border:1px solid rgba(148,163,184,0.12);">
                <h5>Paiements réussis</h5>
                <p class="fs-4 mb-0">{{ $paymentCount ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="mt-5 p-4" style="border-radius:18px;background:rgba(255,255,255,0.03);border:1px solid rgba(148,163,184,0.12);">
        <h5>Résumé rapide</h5>
        <p class="text-muted">Visualisez les tendances clés, les clients récurrents et les services les plus demandés.</p>
        <div class="d-flex flex-column gap-3 mt-4">
            <div class="d-flex justify-content-between">
                <span>Meilleur service</span>
                <strong>{{ $topService ?? 'Non disponible' }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span>Client le plus actif</span>
                <strong>{{ $topClient ?? 'Non disponible' }}</strong>
            </div>
        </div>
    </div>
</div>
@endsection --}}

@extends('layouts.admin')

@section('title', __('messages.rpt_title'))
@section('page-title', __('messages.rpt_title'))
@section('page-subtitle', __('messages.rpt_hero_desc'))

@push('styles')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap');

:root{
    --rp-bg:#0b0f19;
    --rp-card:#111827;
    --rp-card-2:#0f172a;
    --rp-border:rgba(255,255,255,.06);
    --rp-gold:#d4af37;
    --rp-text:#f8fafc;
    --rp-muted:#94a3b8;
    --rp-success:#10b981;
    --rp-danger:#ef4444;
    --rp-shadow:0 20px 45px rgba(0,0,0,.35);
}

.rp-wrapper{
    font-family:'Inter',sans-serif;
    color:var(--rp-text);
}

/* =========================================================
   HERO
========================================================= */

.rp-hero{
    position:relative;
    overflow:hidden;
    border-radius:32px;
    padding:40px;
    margin-bottom:32px;
    background:
        radial-gradient(circle at top right, rgba(212,175,55,.18), transparent 35%),
        radial-gradient(circle at bottom left, rgba(59,130,246,.12), transparent 35%),
        linear-gradient(145deg,#0f172a,#020617);
    border:1px solid rgba(255,255,255,.06);
    box-shadow:var(--rp-shadow);
}

.rp-hero::before{
    content:'';
    position:absolute;
    inset:0;
    background:
        linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
    background-size:40px 40px;
    opacity:.25;
    pointer-events:none;
}

.rp-eyebrow{
    display:inline-flex;
    align-items:center;
    gap:10px;
    font-size:11px;
    font-weight:600;
    letter-spacing:.25em;
    text-transform:uppercase;
    color:var(--rp-gold);
    margin-bottom:18px;
}

.rp-eyebrow::before{
    content:'';
    width:38px;
    height:1px;
    background:var(--rp-gold);
}

.rp-title{
    font-family:'Playfair Display',serif;
    font-size:56px;
    font-weight:700;
    line-height:1;
    margin:0 0 14px;
    color:white;
}

.rp-subtitle{
    max-width:700px;
    color:rgba(255,255,255,.65);
    font-size:15px;
    line-height:1.8;
    margin:0;
}

.rp-date{
    margin-top:24px;
    display:inline-flex;
    align-items:center;
    gap:10px;
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.06);
    padding:10px 16px;
    border-radius:14px;
    font-size:13px;
    color:#cbd5e1;
    backdrop-filter:blur(10px);
}

/* =========================================================
   KPI GRID
========================================================= */

.rp-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:22px;
    margin-bottom:30px;
}

.rp-card{
    position:relative;
    overflow:hidden;
    border-radius:26px;
    padding:26px;
    background:linear-gradient(180deg,var(--rp-card),var(--rp-card-2));
    border:1px solid var(--rp-border);
    box-shadow:var(--rp-shadow);
    transition:.3s ease;
}

.rp-card:hover{
    transform:translateY(-6px);
    border-color:rgba(212,175,55,.25);
}

.rp-card::after{
    content:'';
    position:absolute;
    top:-80px;
    right:-80px;
    width:180px;
    height:180px;
    border-radius:50%;
    background:rgba(212,175,55,.08);
}

.rp-icon{
    width:58px;
    height:58px;
    border-radius:18px;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:22px;
    font-size:22px;
    color:var(--rp-gold);
    background:rgba(212,175,55,.12);
    border:1px solid rgba(212,175,55,.18);
}

.rp-label{
    font-size:12px;
    letter-spacing:.14em;
    text-transform:uppercase;
    color:var(--rp-muted);
    margin-bottom:10px;
}

.rp-value{
    font-size:42px;
    font-weight:700;
    line-height:1;
    margin-bottom:12px;
    color:white;
}

.rp-unit{
    font-size:13px;
    color:#cbd5e1;
}

.rp-trend{
    margin-top:18px;
    display:inline-flex;
    align-items:center;
    gap:8px;
    font-size:12px;
    padding:8px 12px;
    border-radius:999px;
    background:rgba(16,185,129,.12);
    color:#6ee7b7;
    border:1px solid rgba(16,185,129,.18);
}

/* =========================================================
   PANELS
========================================================= */

.rp-panels{
    display:grid;
    grid-template-columns:1.1fr .9fr;
    gap:24px;
}

.rp-panel{
    background:linear-gradient(180deg,#111827,#0b1120);
    border:1px solid var(--rp-border);
    border-radius:28px;
    overflow:hidden;
    box-shadow:var(--rp-shadow);
}

.rp-panel-head{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:28px 30px;
    border-bottom:1px solid rgba(255,255,255,.05);
}

.rp-panel-title{
    margin:0;
    font-size:24px;
    font-weight:700;
    color:white;
}

.rp-panel-sub{
    margin-top:6px;
    font-size:13px;
    color:var(--rp-muted);
}

.rp-badge{
    padding:10px 14px;
    border-radius:999px;
    background:rgba(212,175,55,.12);
    color:var(--rp-gold);
    font-size:11px;
    font-weight:600;
    letter-spacing:.12em;
    text-transform:uppercase;
    border:1px solid rgba(212,175,55,.18);
}

/* =========================================================
   INSIGHTS
========================================================= */

.rp-insights{
    padding:10px 24px 24px;
}

.rp-insight{
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:22px;
    border-radius:20px;
    transition:.25s ease;
}

.rp-insight:hover{
    background:rgba(255,255,255,.03);
}

.rp-insight-left{
    display:flex;
    align-items:center;
    gap:18px;
}

.rp-insight-icon{
    width:52px;
    height:52px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
    color:var(--rp-gold);
    background:rgba(212,175,55,.1);
}

.rp-insight-title{
    font-size:15px;
    font-weight:600;
    color:white;
}

.rp-insight-desc{
    margin-top:4px;
    font-size:13px;
    color:var(--rp-muted);
}

.rp-insight-value{
    font-size:18px;
    font-weight:700;
    color:white;
}

/* =========================================================
   ACTIVITY
========================================================= */

.rp-activity{
    padding:10px 24px 24px;
}

.rp-activity-item{
    display:flex;
    align-items:flex-start;
    gap:16px;
    padding:20px 0;
    border-bottom:1px solid rgba(255,255,255,.05);
}

.rp-activity-item:last-child{
    border-bottom:none;
}

.rp-activity-dot{
    width:12px;
    height:12px;
    border-radius:50%;
    margin-top:6px;
    background:var(--rp-gold);
    box-shadow:0 0 0 6px rgba(212,175,55,.12);
}

.rp-activity-title{
    color:white;
    font-size:14px;
    font-weight:600;
}

.rp-activity-desc{
    margin-top:6px;
    color:var(--rp-muted);
    font-size:13px;
    line-height:1.7;
}

.rp-activity-time{
    margin-top:8px;
    font-size:11px;
    letter-spacing:.08em;
    text-transform:uppercase;
    color:rgba(255,255,255,.35);
}

/* =========================================================
   RESPONSIVE
========================================================= */

@media(max-width:1200px){
    .rp-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .rp-panels{
        grid-template-columns:1fr;
    }
}

@media(max-width:768px){

    .rp-hero{
        padding:28px;
        border-radius:24px;
    }

    .rp-title{
        font-size:38px;
    }

    .rp-grid{
        grid-template-columns:1fr;
    }

    .rp-panel-head{
        flex-direction:column;
        align-items:flex-start;
        gap:16px;
    }

    .rp-insight{
        flex-direction:column;
        align-items:flex-start;
        gap:16px;
    }
}
</style>
@endpush

@section('content')

<div class="rp-wrapper">

    {{-- HERO --}}
    <div class="rp-hero">

        <div class="rp-eyebrow">
            {{ __('messages.rpt_eyebrow') }}
        </div>

        <h1 class="rp-title">
            {{ __('messages.rpt_title') }}
        </h1>

        <p class="rp-subtitle">
            {{ __('messages.rpt_hero_desc') }}
        </p>

        <div class="rp-date">
            <i class="bi bi-calendar3"></i>
            {{ now()->translatedFormat('l d F Y') }}
        </div>

    </div>

    {{-- KPI --}}
    <div class="rp-grid">

        <div class="rp-card">
            <div class="rp-icon">
                <i class="bi bi-cash-stack"></i>
            </div>

            <div class="rp-label">
                {{ __('messages.rpt_kpi_revenue') }}
            </div>

            <div class="rp-value">
                {{ number_format($totalRevenue ?? 0, 0, ',', ' ') }}
            </div>

            <div class="rp-unit">
                {{ __('messages.rpt_kpi_unit_curr') }}
            </div>

            <div class="rp-trend">
                <i class="bi bi-arrow-up"></i>
                {{ __('messages.rpt_kpi_trend_rev') }}
            </div>
        </div>

        <div class="rp-card">
            <div class="rp-icon">
                <i class="bi bi-calendar-check"></i>
            </div>

            <div class="rp-label">
                {{ __('messages.rpt_kpi_bookings') }}
            </div>

            <div class="rp-value">
                {{ $reservationCount ?? 0 }}
            </div>

            <div class="rp-unit">
                {{ __('messages.rpt_kpi_unit_book') }}
            </div>

            <div class="rp-trend">
                <i class="bi bi-arrow-up"></i>
                {{ __('messages.rpt_kpi_trend_book') }}
            </div>
        </div>

        <div class="rp-card">
            <div class="rp-icon">
                <i class="bi bi-credit-card"></i>
            </div>

            <div class="rp-label">
                {{ __('messages.rpt_kpi_payments') }}
            </div>

            <div class="rp-value">
                {{ $paymentCount ?? 0 }}
            </div>

            <div class="rp-unit">
                {{ __('messages.rpt_kpi_unit_pay') }}
            </div>

            <div class="rp-trend">
                <i class="bi bi-check-circle"></i>
                {{ __('messages.rpt_kpi_trend_pay') }}
            </div>
        </div>

        <div class="rp-card">
            <div class="rp-icon">
                <i class="bi bi-people"></i>
            </div>

            <div class="rp-label">
                {{ __('messages.rpt_kpi_vip') }}
            </div>

            <div class="rp-value">
                {{ $vipClients ?? 0 }}
            </div>

            <div class="rp-unit">
                {{ __('messages.rpt_kpi_unit_vip') }}
            </div>

            <div class="rp-trend">
                <i class="bi bi-star-fill"></i>
                {{ __('messages.rpt_kpi_trend_vip') }}
            </div>
        </div>

    </div>

    {{-- PANELS --}}
    <div class="rp-panels">

        {{-- LEFT --}}
        <div class="rp-panel">

            <div class="rp-panel-head">
                <div>
                    <h3 class="rp-panel-title">
                        {{ __('messages.rpt_summary_title') }}
                    </h3>

                    <div class="rp-panel-sub">
                        {{ __('messages.rpt_hero_desc') }}
                    </div>
                </div>

                <span class="rp-badge">
                    Insights
                </span>
            </div>

            <div class="rp-insights">

                <div class="rp-insight">

                    <div class="rp-insight-left">

                        <div class="rp-insight-icon">
                            <i class="bi bi-scissors"></i>
                        </div>

                        <div>
                            <div class="rp-insight-title">
                                {{ __('messages.rpt_best_service_label') }}
                            </div>

                            <div class="rp-insight-desc">
                                {{ __('messages.rpt_hero_desc') }}
                            </div>
                        </div>

                    </div>

                    <div class="rp-insight-value">
                        {{ $topService ?? 'Non disponible' }}
                    </div>

                </div>

                <div class="rp-insight">

                    <div class="rp-insight-left">

                        <div class="rp-insight-icon">
                            <i class="bi bi-person-heart"></i>
                        </div>

                        <div>
                            <div class="rp-insight-title">
                                {{ __('messages.rpt_best_client_label') }}
                            </div>

                            <div class="rp-insight-desc">
                                {{ __('messages.rpt_kpi_unit_vip') }}
                            </div>
                        </div>

                    </div>

                    <div class="rp-insight-value">
                        {{ $topClient ?? 'Non disponible' }}
                    </div>

                </div>

                <div class="rp-insight">

                    <div class="rp-insight-left">

                        <div class="rp-insight-icon">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>

                        <div>
                            <div class="rp-insight-title">
                                {{ __('messages.rpt_revenue_growth_label') }}
                            </div>

                            <div class="rp-insight-desc">
                                {{ __('messages.rpt_kpi_trend_rev') }}
                            </div>
                        </div>

                    </div>

                    <div class="rp-insight-value">
                        +18%
                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="rp-panel">

            <div class="rp-panel-head">
                <div>
                    <h3 class="rp-panel-title">
                        {{ __('messages.rpt_activity_title') }}
                    </h3>

                    <div class="rp-panel-sub">
                        {{ __('messages.rpt_kpi_unit_curr') }}
                    </div>
                </div>

                <span class="rp-badge">
                    Live
                </span>
            </div>

            <div class="rp-activity">

                <div class="rp-activity-item">

                    <div class="rp-activity-dot"></div>

                    <div>
                        <div class="rp-activity-title">
                            {{ __('messages.rpt_activity_2') }}
                        </div>

                        <div class="rp-activity-desc">
                            {{ __('messages.rpt_kpi_unit_pay') }}
                        </div>

                        <div class="rp-activity-time">
                            {{ __('messages.rpt_activity_2_time') }}
                        </div>
                    </div>

                </div>

                <div class="rp-activity-item">

                    <div class="rp-activity-dot"></div>

                    <div>
                        <div class="rp-activity-title">
                            {{ __('messages.rpt_activity_1') }}
                        </div>

                        <div class="rp-activity-desc">
                            {{ __('messages.rpt_kpi_unit_book') }}
                        </div>

                        <div class="rp-activity-time">
                            {{ __('messages.rpt_activity_1_time') }}
                        </div>
                    </div>

                </div>

                <div class="rp-activity-item">

                    <div class="rp-activity-dot"></div>

                    <div>
                        <div class="rp-activity-title">
                            {{ __('messages.rpt_activity_3') }}
                        </div>

                        <div class="rp-activity-desc">
                            {{ __('messages.rpt_kpi_unit_vip') }}
                        </div>

                        <div class="rp-activity-time">
                            {{ __('messages.rpt_activity_3_time') }}
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection