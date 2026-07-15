@extends('layouts.client')

@section('title', __('messages.clt_vip_title'))

@push('styles')
<style>
:root {
    --gold: #d4af37; --gold-light: #f8e08e; --gold-dark: #b8860b;
    --pink: #e83e8c;
}

/* ═══════════════════════════════════════════
   HERO
═══════════════════════════════════════════ */
.vip-hero {
    position: relative; overflow: hidden;
    background: linear-gradient(135deg, #1a1400 0%, #0f0f0f 40%, #0d0d1a 100%);
    border: 2px solid rgba(212,175,55,.55);
    border-radius: 24px; padding: 56px 40px 48px;
    margin: 0 0 32px; text-align: center;
    box-shadow: 0 0 0 1px rgba(212,175,55,.1), 0 8px 40px rgba(212,175,55,.15), inset 0 1px 0 rgba(212,175,55,.2);
}
.vip-hero::before {
    content: ''; position: absolute; inset: 0; border-radius: 24px;
    background:
        radial-gradient(ellipse 70% 60% at 50% -10%, rgba(212,175,55,.22), transparent),
        radial-gradient(ellipse 40% 40% at 0% 100%, rgba(212,175,55,.07), transparent),
        radial-gradient(ellipse 40% 40% at 100% 100%, rgba(212,175,55,.07), transparent);
    pointer-events: none;
}
.vip-hero-deco {
    position: absolute; font-size: 180px; opacity: .025; color: var(--gold);
    top: -20px; right: -20px; line-height: 1; pointer-events: none;
    font-family: 'Playfair Display', serif;
}
.vip-hero-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(212,175,55,.1); border: 1px solid rgba(212,175,55,.3);
    color: var(--gold-light); font-size: .68rem; font-weight: 800;
    letter-spacing: .14em; text-transform: uppercase;
    padding: 5px 16px; border-radius: 50px; margin-bottom: 20px;
    position: relative;
}
.vip-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 4.5vw, 3rem) !important; font-weight: 900;
    margin: 0 0 12px; line-height: 1.1; position: relative;
    background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 40%, var(--gold-dark) 70%, var(--gold-light) 100%) !important;
    background-size: 200% auto !important;
    -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important;
    color: transparent !important;
    animation: shimmer 4s linear infinite;
}
@keyframes shimmer { to { background-position: 200% center; } }
.vip-hero p {
    color: rgba(255,255,255,.45); font-size: .95rem; max-width: 480px;
    margin: 0 auto 32px; position: relative;
}

/* Stats row */
.vip-hero-stats {
    display: flex; justify-content: center; gap: 0;
    background: rgba(212,175,55,.08); border: 1.5px solid rgba(212,175,55,.4);
    border-radius: 16px; overflow: hidden; position: relative;
    max-width: 520px; margin: 0 auto;
    box-shadow: 0 0 16px rgba(212,175,55,.12);
}
.vip-hero-stat {
    flex: 1; padding: 18px 12px; text-align: center;
    border-right: 1px solid rgba(212,175,55,.12);
}
.vip-hero-stat:last-child { border-right: none; }
.vip-hero-stat-val {
    font-size: 1.5rem; font-weight: 900; color: var(--gold);
    font-family: 'Playfair Display', serif; display: block;
}
.vip-hero-stat-lbl {
    font-size: .65rem; color: rgba(255,255,255,.35); text-transform: uppercase;
    letter-spacing: .08em; margin-top: 2px; display: block;
}

/* ═══════════════════════════════════════════
   ABONNEMENT ACTUEL
═══════════════════════════════════════════ */
.vip-active-banner {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: 16px;
    background: linear-gradient(135deg, rgba(212,175,55,.12), rgba(212,175,55,.04));
    border: 2px solid rgba(212,175,55,.55);
    border-radius: 18px; padding: 22px 28px; margin-bottom: 32px;
    box-shadow: 0 0 0 1px rgba(212,175,55,.1), 0 6px 30px rgba(212,175,55,.2);
}
.vip-active-left { display: flex; align-items: center; gap: 16px; }
.vip-active-icon {
    width: 48px; height: 48px; border-radius: 14px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: #0f0f0f;
    box-shadow: 0 4px 14px rgba(212,175,55,.4);
}
.vip-active-name { font-weight: 800; color: var(--gold); font-size: .95rem; margin: 0 0 3px; }
.vip-active-meta { font-size: .78rem; color: rgba(255,255,255,.4); }
.vip-active-pills { display: flex; gap: 8px; flex-wrap: wrap; }
.vip-active-pill {
    background: rgba(212,175,55,.1); border: 1px solid rgba(212,175,55,.2);
    color: rgba(255,255,255,.6); font-size: .7rem; font-weight: 600;
    padding: 4px 12px; border-radius: 20px;
}
.btn-cancel-sub {
    display: inline-flex; align-items: center; gap: 7px;
    background: transparent; border: 1px solid rgba(248,113,113,.3);
    color: rgba(248,113,113,.7); padding: 9px 18px; border-radius: 10px;
    font-size: .78rem; font-weight: 600; cursor: pointer; transition: .18s;
    font-family: 'Inter', sans-serif; white-space: nowrap;
}
.btn-cancel-sub:hover { background: rgba(248,113,113,.1); border-color: rgba(248,113,113,.5); color: #f87171; }

/* ═══════════════════════════════════════════
   SECTION TITRE
═══════════════════════════════════════════ */
.vip-section-label {
    text-align: center; margin-bottom: 28px;
}
.vip-section-eyebrow {
    font-size: .68rem; font-weight: 800; text-transform: uppercase;
    letter-spacing: .14em; color: var(--gold); margin-bottom: 8px; display: block;
}
.vip-section-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.5rem; font-weight: 900; color: #fff !important;
    -webkit-text-fill-color: #fff !important; background: none !important;
    margin: 0;
}
.vip-section-title span { color: var(--gold) !important; -webkit-text-fill-color: var(--gold) !important; }

/* ═══════════════════════════════════════════
   PLANS
═══════════════════════════════════════════ */
.vip-plans-grid {
    display: grid; grid-template-columns: repeat(3, 1fr);
    gap: 20px; margin-bottom: 40px; align-items: start;
}
.vip-plan-card {
    border-radius: 22px; overflow: visible; position: relative;
    transition: transform .25s, box-shadow .25s;
}
/* Wrapper interne pour overflow:hidden sans couper le badge */
.vip-plan-inner {
    background: rgba(20,18,12,.9); backdrop-filter: blur(16px);
    border: 2px solid rgba(212,175,55,.45);
    border-radius: 22px; overflow: hidden;
    box-shadow: 0 4px 30px rgba(0,0,0,.5), 0 0 0 1px rgba(212,175,55,.08), inset 0 1px 0 rgba(255,255,255,.05);
    transition: border-color .25s, box-shadow .25s;
}
.vip-plan-card:hover .vip-plan-inner {
    border-color: rgba(212,175,55,.7);
    box-shadow: 0 10px 40px rgba(0,0,0,.55), 0 0 30px rgba(212,175,55,.2), inset 0 1px 0 rgba(255,255,255,.07);
}
.vip-plan-card:hover { transform: translateY(-6px); }

.vip-plan-card.featured { transform: translateY(-10px); }
.vip-plan-card.featured .vip-plan-inner {
    border: 2.5px solid rgba(212,175,55,.85);
    box-shadow: 0 8px 50px rgba(0,0,0,.55), 0 0 60px rgba(212,175,55,.25), 0 0 0 1px rgba(212,175,55,.2), inset 0 1px 0 rgba(212,175,55,.15);
}
.vip-plan-card.featured:hover { transform: translateY(-15px); }
.vip-plan-card.featured:hover .vip-plan-inner {
    border-color: var(--gold);
    box-shadow: 0 16px 60px rgba(0,0,0,.6), 0 0 80px rgba(212,175,55,.35), inset 0 1px 0 rgba(212,175,55,.2);
}

/* Badge flottant */
.vip-plan-ribbon {
    position: absolute; top: -13px; left: 50%; transform: translateX(-50%);
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    color: #0f0f0f; font-size: .65rem; font-weight: 900;
    letter-spacing: .1em; text-transform: uppercase;
    padding: 5px 18px; border-radius: 20px;
    box-shadow: 0 4px 16px rgba(212,175,55,.45);
    white-space: nowrap; z-index: 2;
}

/* En-tête carte */
.vip-plan-head {
    padding: 28px 24px 22px;
    background: linear-gradient(180deg, rgba(212,175,55,.07) 0%, transparent 100%);
    border-bottom: 1px solid rgba(212,175,55,.1);
    position: relative;
}
.vip-plan-head::after {
    content: ''; position: absolute; bottom: 0; left: 24px; right: 24px; height: 1px;
    background: linear-gradient(to right, transparent, rgba(212,175,55,.2), transparent);
}
.vip-plan-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.2rem; font-weight: 800; color: rgba(255,255,255,.9) !important;
    -webkit-text-fill-color: rgba(255,255,255,.9) !important; background: none !important;
    margin: 0 0 16px;
}
.vip-plan-price-row { display: flex; align-items: flex-start; gap: 4px; margin-bottom: 6px; }
.vip-plan-curr { font-size: 1rem; font-weight: 700; color: var(--gold); margin-top: 8px; }
.vip-plan-amount {
    font-size: 2.8rem; font-weight: 900; line-height: 1;
    background: linear-gradient(135deg, var(--gold-light), var(--gold)) !important;
    -webkit-background-clip: text !important; -webkit-text-fill-color: transparent !important;
    color: transparent !important;
    font-family: 'Playfair Display', serif;
}
.vip-plan-period {
    font-size: .72rem; color: rgba(255,255,255,.28);
    margin-top: 4px; display: block;
}
.vip-plan-saving {
    display: inline-block; margin-top: 8px;
    background: rgba(52,211,153,.1); border: 1px solid rgba(52,211,153,.25);
    color: #34d399; font-size: .65rem; font-weight: 700;
    padding: 3px 10px; border-radius: 20px; letter-spacing: .04em;
}

/* Corps carte */
.vip-plan-body { padding: 20px 24px 24px; }
.vip-feat-list { list-style: none; padding: 0; margin: 0 0 24px; display: flex; flex-direction: column; gap: 11px; }
.vip-feat-item { display: flex; align-items: center; gap: 11px; font-size: .83rem; color: rgba(255,255,255,.55); }
.vip-feat-check {
    width: 20px; height: 20px; border-radius: 50%; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 9px;
}
.vip-feat-check.green { background: rgba(52,211,153,.15); color: #34d399; }
.vip-feat-check.gold  { background: rgba(212,175,55,.15); color: var(--gold); }
.vip-feat-item strong { color: rgba(255,255,255,.78); font-weight: 600; }

/* Bouton */
.btn-plan {
    display: block; width: 100%; text-align: center;
    padding: 13px 20px; border-radius: 12px;
    font-size: .86rem; font-weight: 700; cursor: pointer; transition: .22s;
    border: 1.5px solid rgba(212,175,55,.3);
    background: rgba(212,175,55,.06); color: var(--gold);
    font-family: 'Inter', sans-serif; letter-spacing: .02em;
}
.btn-plan:hover {
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    color: #0f0f0f; border-color: transparent;
    box-shadow: 0 6px 22px rgba(212,175,55,.4);
    transform: translateY(-1px);
}
.vip-plan-card.featured .btn-plan {
    background: linear-gradient(135deg, var(--gold), var(--gold-dark));
    color: #0f0f0f; border-color: transparent;
    box-shadow: 0 4px 18px rgba(212,175,55,.35);
}
.vip-plan-card.featured .btn-plan:hover {
    box-shadow: 0 8px 32px rgba(212,175,55,.55);
    transform: translateY(-2px);
}
.btn-plan-inactive {
    text-align: center; font-size: .78rem; color: rgba(255,255,255,.2);
    padding: 13px 0; display: flex; align-items: center; justify-content: center; gap: 7px;
}

/* ═══════════════════════════════════════════
   TABLEAU COMPARATIF
═══════════════════════════════════════════ */
.vip-compare {
    background: rgba(255,255,255,.025);
    border: 2px solid rgba(212,175,55,.45);
    border-radius: 20px; overflow: hidden;
    margin-bottom: 36px;
    box-shadow: 0 4px 30px rgba(0,0,0,.4), 0 0 0 1px rgba(212,175,55,.08);
}
.vip-compare table { width: 100%; border-collapse: collapse; }
.vip-compare thead tr { background: rgba(212,175,55,.07); }
.vip-compare th {
    padding: 16px 20px; font-size: .75rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .08em;
    border-bottom: 1px solid rgba(212,175,55,.14);
}
.vip-compare th:first-child { color: rgba(255,255,255,.4); text-align: left; }
.vip-compare th:not(:first-child) { text-align: center; color: var(--gold); }
.vip-compare th.th-featured { color: var(--gold-light); }
.vip-compare td {
    padding: 13px 20px; font-size: .82rem;
    border-bottom: 1px solid rgba(255,255,255,.04);
}
.vip-compare tr:last-child td { border-bottom: none; }
.vip-compare tr:hover td { background: rgba(212,175,55,.03); }
.vip-compare td:first-child { color: rgba(255,255,255,.45); }
.vip-compare td:not(:first-child) { text-align: center; color: rgba(255,255,255,.65); font-weight: 600; }
.vip-compare td.td-featured { color: var(--gold) !important; }
.cmp-yes { color: #34d399 !important; font-size: 15px; }
.cmp-no  { color: rgba(255,255,255,.18) !important; font-size: 15px; }

/* ═══════════════════════════════════════════
   AVANTAGES
═══════════════════════════════════════════ */
.vip-benefits-wrap {
    background: rgba(255,255,255,.02);
    border: 2px solid rgba(212,175,55,.45);
    border-radius: 22px; padding: 36px 30px;
    box-shadow: 0 4px 32px rgba(0,0,0,.35), 0 0 0 1px rgba(212,175,55,.08);
    margin-bottom: 36px;
}
.vip-benefits-grid {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;
}
.vip-benefit-card {
    background: rgba(212,175,55,.03);
    border: 1.5px solid rgba(212,175,55,.38);
    border-radius: 16px; padding: 22px 18px;
    transition: .22s; text-align: center;
    box-shadow: 0 2px 14px rgba(0,0,0,.25), 0 0 0 1px rgba(212,175,55,.06);
}
.vip-benefit-card:hover {
    background: rgba(212,175,55,.07); border-color: rgba(212,175,55,.65);
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,.35), 0 0 20px rgba(212,175,55,.15);
}
.vip-benefit-icon {
    width: 50px; height: 50px; border-radius: 14px; margin: 0 auto 14px;
    background: linear-gradient(135deg, rgba(212,175,55,.18), rgba(212,175,55,.05));
    border: 1.5px solid rgba(212,175,55,.28);
    display: flex; align-items: center; justify-content: center;
    font-size: 19px; color: var(--gold);
    box-shadow: 0 4px 12px rgba(212,175,55,.15);
}
.vip-benefit-name { font-size: .88rem; font-weight: 700; color: rgba(255,255,255,.85); margin: 0 0 6px; }
.vip-benefit-desc { font-size: .74rem; color: rgba(255,255,255,.33); line-height: 1.65; margin: 0; }

/* ═══════════════════════════════════════════
   GARANTIE
═══════════════════════════════════════════ */
.vip-guarantee {
    display: flex; align-items: center; gap: 24px; flex-wrap: wrap;
    background: linear-gradient(135deg, rgba(52,211,153,.06), rgba(52,211,153,.02));
    border: 2px solid rgba(52,211,153,.45);
    border-radius: 18px; padding: 24px 28px;
    box-shadow: 0 4px 24px rgba(0,0,0,.3), 0 0 0 1px rgba(52,211,153,.08), 0 0 20px rgba(52,211,153,.08);
}
.vip-guarantee-icon {
    width: 54px; height: 54px; border-radius: 50%; flex-shrink: 0;
    background: rgba(52,211,153,.12); border: 1.5px solid rgba(52,211,153,.25);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #34d399;
}
.vip-guarantee-title {
    font-weight: 800; color: #fff; font-size: .95rem; margin: 0 0 4px;
}
.vip-guarantee-text {
    font-size: .8rem; color: rgba(255,255,255,.4); margin: 0; line-height: 1.6;
}
.vip-guarantee-badges { display: flex; gap: 8px; flex-wrap: wrap; margin-left: auto; }
.vip-guarantee-badge {
    display: flex; align-items: center; gap: 6px;
    background: rgba(52,211,153,.08); border: 1px solid rgba(52,211,153,.2);
    color: rgba(255,255,255,.55); font-size: .7rem; font-weight: 600;
    padding: 6px 13px; border-radius: 20px;
}
.vip-guarantee-badge i { color: #34d399; }

/* ═══════════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════════ */
@media (max-width: 900px) {
    .vip-plans-grid { grid-template-columns: 1fr; }
    .vip-plan-card.featured, .vip-plan-card:hover { transform: none; }
    .vip-plan-card.featured .vip-plan-inner { border-color: rgba(212,175,55,.45); }
    .vip-compare { overflow-x: auto; }
    .vip-benefits-grid { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 640px) {
    .vip-hero { padding: 36px 20px 32px; }
    .vip-hero-stats { flex-direction: column; }
    .vip-hero-stat { border-right: none; border-bottom: 1px solid rgba(212,175,55,.12); }
    .vip-hero-stat:last-child { border-bottom: none; }
    .vip-benefits-grid { grid-template-columns: 1fr; }
    .vip-guarantee { flex-direction: column; text-align: center; }
    .vip-guarantee-badges { margin-left: 0; justify-content: center; }
}
</style>
@endpush

@section('content')
<div style="padding:24px 20px 60px; max-width:1080px; margin:0 auto;">

    {{-- ── HERO ─────────────────────────────────────────────── --}}
    <div class="vip-hero">
        <div class="vip-hero-deco">♛</div>
        <div class="vip-hero-eyebrow">
            <i class="fa-solid fa-crown"></i>
            {{ __('messages.clt_vip_program') }}
        </div>
        <h1>Marol <em style="-webkit-text-fill-color:inherit;">VIP</em></h1>
        <p>{{ __('messages.clt_vip_subtitle') }}</p>
        <div class="vip-hero-stats">
            <div class="vip-hero-stat">
                <span class="vip-hero-stat-val">500+</span>
                <span class="vip-hero-stat-lbl">{{ __('messages.clt_vip_stat_members') }}</span>
            </div>
            <div class="vip-hero-stat">
                <span class="vip-hero-stat-val">4.9</span>
                <span class="vip-hero-stat-lbl">{{ __('messages.clt_vip_stat_rating') }}</span>
            </div>
            <div class="vip-hero-stat">
                <span class="vip-hero-stat-val">20%</span>
                <span class="vip-hero-stat-lbl">{{ __('messages.clt_vip_stat_discount') }}</span>
            </div>
        </div>
    </div>

    {{-- ── ABONNEMENT ACTIF ─────────────────────────────────── --}}
    @if($currentVip && $currentVip->isActive())
    <div class="vip-active-banner">
        <div class="vip-active-left">
            <div class="vip-active-icon"><i class="fa-solid fa-crown"></i></div>
            <div>
                <div class="vip-active-name">{{ __('messages.clt_active_subscription') }} · {{ __('messages.vip_plan_' . $currentVip->plan) }}</div>
                <div class="vip-active-meta">{{ __('messages.clt_vip_active_label') }} {{ $currentVip->ends_at->format('d/m/Y') }} · {{ number_format($currentVip->price / 100, 2) }}</div>
            </div>
        </div>
        <div class="vip-active-pills">
            <span class="vip-active-pill"><i class="fa-solid fa-tag" style="color:var(--gold);margin-right:4px;"></i>{{ $currentVip->discount_percentage }}% {{ __('messages.clt_vip_reduction') }}</span>
            <span class="vip-active-pill"><i class="fa-solid fa-calendar-check" style="color:var(--gold);margin-right:4px;"></i>{{ $currentVip->reservation_count_included }} {{ __('messages.clt_vip_bookings_short') }}</span>
            @if($currentVip->free_service_monthly)
            <span class="vip-active-pill"><i class="fa-solid fa-star" style="color:var(--gold);margin-right:4px;"></i>{{ __('messages.clt_vip_free_service') }}</span>
            @endif
        </div>
        <button type="button" class="btn-cancel-sub" onclick="openCancelModal()">
            <i class="fa-solid fa-xmark"></i> {{ __('messages.clt_cancel_subscription') }}
        </button>
    </div>
    @endif

    {{-- ── MODAL ANNULATION ────────────────────────────────── --}}
    @if($currentVip && $currentVip->isActive())
    <div id="cancelModal" style="
        display:none; position:fixed; inset:0; z-index:9999;
        background:rgba(0,0,0,.72); backdrop-filter:blur(6px);
        align-items:center; justify-content:center; padding:20px;
    ">
        <div style="
            background:linear-gradient(135deg,#1a1400,#0f0f0f);
            border:2px solid rgba(248,113,113,.45);
            border-radius:24px; padding:36px 32px; max-width:460px; width:100%;
            box-shadow:0 0 0 1px rgba(248,113,113,.12), 0 16px 60px rgba(0,0,0,.7);
            position:relative; text-align:center;
        ">
            {{-- Icône --}}
            <div style="
                width:64px;height:64px;border-radius:50%;margin:0 auto 20px;
                background:rgba(248,113,113,.12);border:1.5px solid rgba(248,113,113,.3);
                display:flex;align-items:center;justify-content:center;
                font-size:24px;color:#f87171;
                box-shadow:0 0 24px rgba(248,113,113,.2);
            ">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <h3 style="font-family:'Playfair Display',serif;font-size:1.35rem;color:#fff;margin:0 0 10px;">
                Annuler votre abonnement ?
            </h3>
            <p style="color:rgba(255,255,255,.45);font-size:.85rem;line-height:1.65;margin:0 0 8px;">
                Vous conserverez tous vos avantages VIP jusqu'au
                <strong style="color:var(--gold);">{{ $currentVip->ends_at->format('d/m/Y') }}</strong>.
            </p>
            <p style="color:rgba(255,255,255,.3);font-size:.78rem;margin:0 0 28px;line-height:1.6;">
                Après cette date, votre accès VIP sera désactivé et vous ne serez plus débité.
            </p>

            {{-- Récap plan --}}
            <div style="
                background:rgba(248,113,113,.06);border:1px solid rgba(248,113,113,.18);
                border-radius:12px;padding:14px 18px;margin-bottom:28px;
                display:flex;align-items:center;justify-content:space-between;
                font-size:.82rem;
            ">
                <span style="color:rgba(255,255,255,.45);">Plan actuel</span>
                <span style="color:#f87171;font-weight:700;">
                    <i class="fa-solid fa-crown" style="margin-right:5px;"></i>
                    {{ __('messages.vip_plan_' . $currentVip->plan) }}
                    · {{ number_format($currentVip->price / 100, 2) }}
                </span>
            </div>

            {{-- Boutons --}}
            <div style="display:flex;gap:12px;flex-direction:column;">
                <button onclick="closeCancelModal()" style="
                    background:linear-gradient(135deg,var(--gold),var(--gold-dark));
                    color:#0f0f0f;border:none;border-radius:12px;
                    padding:14px 20px;font-size:.9rem;font-weight:800;
                    cursor:pointer;font-family:'Inter',sans-serif;
                    box-shadow:0 6px 20px rgba(212,175,55,.35);
                    transition:.2s;
                ">
                    <i class="fa-solid fa-crown" style="margin-right:7px;"></i>
                    Maintenir mon abonnement VIP
                </button>

                <form method="POST" action="{{ route('client.vip.cancel') }}">
                    @csrf
                    <button type="submit" style="
                        background:transparent;border:1.5px solid rgba(248,113,113,.35);
                        color:rgba(248,113,113,.7);border-radius:12px;
                        padding:12px 20px;width:100%;font-size:.84rem;font-weight:600;
                        cursor:pointer;font-family:'Inter',sans-serif;transition:.18s;
                    "
                    onmouseover="this.style.background='rgba(248,113,113,.1)';this.style.borderColor='rgba(248,113,113,.55)';this.style.color='#f87171';"
                    onmouseout="this.style.background='transparent';this.style.borderColor='rgba(248,113,113,.35)';this.style.color='rgba(248,113,113,.7)';"
                    >
                        <i class="fa-solid fa-xmark" style="margin-right:6px;"></i>
                        Confirmer l'annulation
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    function openCancelModal()  { document.getElementById('cancelModal').style.display = 'flex'; }
    function closeCancelModal() { document.getElementById('cancelModal').style.display = 'none'; }
    document.getElementById('cancelModal').addEventListener('click', function(e) {
        if (e.target === this) closeCancelModal();
    });
    </script>
    @endif

    {{-- ── PLANS ────────────────────────────────────────────── --}}
    <div class="vip-section-label">
        <span class="vip-section-eyebrow">{{ __('messages.clt_vip_choose_plan') }}</span>
        <h2 class="vip-section-title">{!! __('messages.clt_vip_our_plans') !!}</h2>
    </div>

    <div class="vip-plans-grid">
        @foreach($plans as $key => $plan)
        @php
            $savings = match($key) {
                'quarterly' => __('messages.clt_vip_saving_quarterly'),
                'annual'    => __('messages.clt_vip_saving_annual'),
                default     => null,
            };
        @endphp
        <div class="vip-plan-card {{ $key === 'quarterly' ? 'featured' : '' }}">

            @if($key === 'quarterly')
            <div class="vip-plan-ribbon">⭐ {{ __('messages.clt_vip_best_value') }}</div>
            @endif

            <div class="vip-plan-inner">
                <div class="vip-plan-head">
                    <div class="vip-plan-name">{{ __('messages.vip_plan_' . $key) }}</div>
                    <div class="vip-plan-price-row">
                        <span class="vip-plan-amount">{{ number_format($plan['price'] / 100, 0, '.', ',') }}</span>
                    </div>
                    <span class="vip-plan-period">{{ $plan['duration_months'] }} {{ __('messages.clt_vip_months') }}</span>
                    @if($savings)
                    <span class="vip-plan-saving">✓ {{ $savings }}</span>
                    @endif
                </div>

                <div class="vip-plan-body">
                    <ul class="vip-feat-list">
                        <li class="vip-feat-item">
                            <span class="vip-feat-check green"><i class="fa-solid fa-check"></i></span>
                            <strong>{{ $plan['benefits']['discount_percentage'] }}{{ __('messages.clt_vip_discount_pct') }}</strong>
                        </li>
                        <li class="vip-feat-item">
                            <span class="vip-feat-check green"><i class="fa-solid fa-check"></i></span>
                            <strong>{{ $plan['benefits']['reservation_count_included'] }}</strong>&nbsp;{{ __('messages.clt_vip_incl_bookings') }}
                        </li>
                        <li class="vip-feat-item">
                            <span class="vip-feat-check green"><i class="fa-solid fa-check"></i></span>
                            {{ __('messages.clt_vip_priority_bk_lbl') }}
                        </li>
                        @if($plan['benefits']['free_service_monthly'])
                        <li class="vip-feat-item">
                            <span class="vip-feat-check gold"><i class="fa-solid fa-star"></i></span>
                            <strong>{{ __('messages.clt_vip_free_monthly') }}</strong>
                        </li>
                        @endif
                    </ul>

                    @if(!$currentVip || !$currentVip->isActive())
                        <form method="POST" action="{{ route('client.vip.subscribe') }}">
                            @csrf
                            <input type="hidden" name="plan" value="{{ $key }}">
                            <button type="submit" class="btn-plan">
                                {{ __('messages.clt_vip_subscribe_now') }}
                                <i class="fa-solid fa-arrow-right" style="margin-left:6px;"></i>
                            </button>
                        </form>
                    @else
                        <div class="btn-plan-inactive">
                            <i class="fa-solid fa-check" style="color:#34d399;"></i>
                            {{ __('messages.clt_vip_active_label') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── TABLEAU COMPARATIF ───────────────────────────────── --}}
    <div class="vip-compare">
        <table>
            <thead>
                <tr>
                    <th>{{ __('messages.clt_vip_cmp_feature') }}</th>
                    <th>{{ __('messages.vip_plan_monthly') }}</th>
                    <th class="th-featured">{{ __('messages.vip_plan_quarterly') }}</th>
                    <th>{{ __('messages.vip_plan_annual') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ __('messages.clt_vip_cmp_discount') }}</td>
                    <td>10%</td>
                    <td class="td-featured">15%</td>
                    <td>20%</td>
                </tr>
                <tr>
                    <td>{{ __('messages.clt_vip_cmp_bookings') }}</td>
                    <td>4</td>
                    <td class="td-featured">12</td>
                    <td>50</td>
                </tr>
                <tr>
                    <td>{{ __('messages.clt_vip_cmp_priority') }}</td>
                    <td><span class="cmp-yes">✓</span></td>
                    <td><span class="cmp-yes">✓</span></td>
                    <td><span class="cmp-yes">✓</span></td>
                </tr>
                <tr>
                    <td>{{ __('messages.clt_vip_cmp_free_svc') }}</td>
                    <td><span class="cmp-no">—</span></td>
                    <td><span class="cmp-yes">✓</span></td>
                    <td><span class="cmp-yes">✓</span></td>
                </tr>
                <tr>
                    <td>{{ __('messages.clt_vip_cmp_support') }}</td>
                    <td><span class="cmp-no">—</span></td>
                    <td><span class="cmp-yes">✓</span></td>
                    <td><span class="cmp-yes">✓</span></td>
                </tr>
                <tr>
                    <td>{{ __('messages.clt_vip_cmp_status') }}</td>
                    <td><span class="cmp-no">—</span></td>
                    <td><span class="cmp-no">—</span></td>
                    <td><span class="cmp-yes">✓</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- ── AVANTAGES ────────────────────────────────────────── --}}
    <div class="vip-benefits-wrap">
        <div class="vip-section-label" style="margin-bottom:24px;">
            <span class="vip-section-eyebrow">{{ __('messages.clt_vip_incl_all_plans') }}</span>
            <h2 class="vip-section-title">{{ __('messages.clt_vip_all_benefits') }}</h2>
        </div>
        <div class="vip-benefits-grid">
            <div class="vip-benefit-card">
                <div class="vip-benefit-icon"><i class="fa-solid fa-calendar-check"></i></div>
                <div class="vip-benefit-name">{{ __('messages.clt_vip_priority_bk') }}</div>
                <p class="vip-benefit-desc">{{ __('messages.clt_vip_priority_bk_txt') }}</p>
            </div>
            <div class="vip-benefit-card">
                <div class="vip-benefit-icon"><i class="fa-solid fa-tag"></i></div>
                <div class="vip-benefit-name">{{ __('messages.clt_vip_discounts') }}</div>
                <p class="vip-benefit-desc">{{ __('messages.clt_vip_discounts_txt') }}</p>
            </div>
            <div class="vip-benefit-card">
                <div class="vip-benefit-icon"><i class="fa-solid fa-gift"></i></div>
                <div class="vip-benefit-name">{{ __('messages.clt_vip_free_svc') }}</div>
                <p class="vip-benefit-desc">{{ __('messages.clt_vip_free_svc_txt') }}</p>
            </div>
            <div class="vip-benefit-card">
                <div class="vip-benefit-icon"><i class="fa-solid fa-bell"></i></div>
                <div class="vip-benefit-name">{{ __('messages.clt_vip_exclusive_notif') }}</div>
                <p class="vip-benefit-desc">{{ __('messages.clt_vip_exclusive_txt') }}</p>
            </div>
            <div class="vip-benefit-card">
                <div class="vip-benefit-icon"><i class="fa-solid fa-headset"></i></div>
                <div class="vip-benefit-name">{{ __('messages.clt_vip_support') }}</div>
                <p class="vip-benefit-desc">{{ __('messages.clt_vip_support_txt') }}</p>
            </div>
            <div class="vip-benefit-card">
                <div class="vip-benefit-icon"><i class="fa-solid fa-crown"></i></div>
                <div class="vip-benefit-name">{{ __('messages.clt_vip_premium_status') }}</div>
                <p class="vip-benefit-desc">{{ __('messages.clt_vip_premium_txt') }}</p>
            </div>
        </div>
    </div>

    {{-- ── GARANTIE ─────────────────────────────────────────── --}}
    <div class="vip-guarantee">
        <div class="vip-guarantee-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <div>
            <div class="vip-guarantee-title">{{ __('messages.clt_vip_guarantee_title') }}</div>
            <p class="vip-guarantee-text">{{ __('messages.clt_vip_guarantee_text') }}</p>
        </div>
        <div class="vip-guarantee-badges">
            <span class="vip-guarantee-badge"><i class="fa-solid fa-lock"></i> {{ __('messages.clt_vip_secure_payment') }}</span>
            <span class="vip-guarantee-badge"><i class="fa-solid fa-rotate-left"></i> {{ __('messages.clt_vip_free_cancel') }}</span>
        </div>
    </div>

</div>
@endsection
