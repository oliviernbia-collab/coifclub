@extends('layouts.employee')

@section('title', 'Mes Services')

@section('content')

@php $routePrefix = request()->routeIs('employee.*') ? 'employee' : 'prestataire'; @endphp

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

/* ── PAGE ── */
.svc-page { padding: 0 0 60px; }

/* ── BANNER ── */
.svc-banner {
    border-radius: 22px;
    padding: 26px 32px;
    background: linear-gradient(135deg, #160d2a 0%, #1e1040 55%, #120e22 100%);
    border: 1px solid rgba(233,30,140,.18);
    position: relative;
    overflow: hidden;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}
.svc-banner::before {
    content: '';
    position: absolute;
    width: 220px; height: 220px;
    border-radius: 50%;
    background: rgba(233,30,140,.07);
    top: -80px; right: -60px;
    pointer-events: none;
}
.svc-banner::after {
    content: '✂';
    position: absolute;
    right: 36px; top: 50%;
    transform: translateY(-50%);
    font-size: 4rem;
    opacity: .05;
    pointer-events: none;
}
.svc-banner-eyebrow {
    font-size: 10.5px; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
    color: rgba(255,255,255,.45); margin-bottom: 6px;
}
.svc-banner-title {
    font-size: 1.6rem; font-weight: 800;
    color: #fff; margin: 0 0 6px;
    line-height: 1.15;
}
.svc-banner-sub {
    color: rgba(255,255,255,.55);
    font-size: .87rem; margin: 0;
}
.svc-banner-add {
    display: inline-flex; align-items: center; gap: 9px;
    background: linear-gradient(135deg, #e91e8c, #c0156d);
    color: #fff; text-decoration: none;
    padding: 11px 22px; border-radius: 14px;
    font-weight: 700; font-size: .87rem;
    white-space: nowrap; flex-shrink: 0;
    transition: .25s ease;
    box-shadow: 0 6px 20px rgba(233,30,140,.35);
}
.svc-banner-add:hover {
    color: #fff; transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(233,30,140,.5);
}

/* ── STATS ── */
.svc-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
@media (max-width: 768px) { .svc-stats { grid-template-columns: 1fr; } }
@media (max-width: 992px) and (min-width: 769px) { .svc-stats { grid-template-columns: repeat(3, 1fr); } }

.svc-stat {
    border-radius: 18px;
    padding: 18px 22px;
    color: #fff;
    position: relative;
    overflow: hidden;
    min-height: 100px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}
.svc-stat::before {
    content: '';
    position: absolute;
    width: 100px; height: 100px;
    border-radius: 50%;
    background: rgba(255,255,255,.07);
    top: -30px; right: -30px;
}
.svc-stat-label {
    font-size: .78rem; font-weight: 600;
    opacity: .85; letter-spacing: .03em;
}
.svc-stat-num {
    font-size: 2rem; font-weight: 800;
    line-height: 1; margin: 6px 0 3px;
}
.svc-stat-hint { font-size: .75rem; opacity: .65; }
.svc-stat-icon {
    position: absolute; right: 14px; bottom: 10px;
    font-size: 2.6rem; opacity: .1;
}
.svc-stat-total   { background: linear-gradient(135deg, #6b21a8, #7c3aed); }
.svc-stat-active  { background: linear-gradient(135deg, #059669, #10b981); }
.svc-stat-inactive{ background: linear-gradient(135deg, #be185d, #e91e8c); }

/* ── GRID ── */
.svc-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}
@media (max-width: 1200px) { .svc-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 640px)  { .svc-grid { grid-template-columns: 1fr; } }

/* ── CARD ── */
.svc-card {
    background: rgba(255,255,255,.05);
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(233,30,140,.12);
    display: flex;
    flex-direction: column;
    transition: transform .3s ease, border-color .25s, box-shadow .3s ease;
}
.svc-card:hover {
    transform: translateY(-4px);
    border-color: rgba(233,30,140,.32);
    box-shadow: 0 10px 32px rgba(233,30,140,.15);
}

/* image */
.svc-img-wrap { position: relative; overflow: hidden; flex-shrink: 0; }
.svc-img-wrap img {
    width: 100%; height: 155px;
    object-fit: cover; display: block;
    transition: transform .5s ease;
}
.svc-card:hover .svc-img-wrap img { transform: scale(1.05); }
.svc-img-placeholder {
    width: 100%; height: 155px;
    background: rgba(255,255,255,.04);
    border-bottom: 1px solid rgba(255,255,255,.06);
    display: flex; align-items: center; justify-content: center;
    font-size: 3rem;
}
.svc-img-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(14,10,28,.65), transparent 55%);
}

/* status badge */
.svc-status {
    position: absolute; top: 10px; right: 10px;
    padding: 4px 11px; border-radius: 999px;
    font-size: .68rem; font-weight: 700;
    z-index: 2; backdrop-filter: blur(10px);
    letter-spacing: .04em; text-transform: uppercase;
}
.svc-status-on  { background: rgba(16,185,129,.2);  color: #34d399; border: 1px solid rgba(16,185,129,.3); }
.svc-status-off { background: rgba(239,68,68,.16); color: #f87171; border: 1px solid rgba(239,68,68,.25); }

/* body */
.svc-body { padding: 16px 18px 0; flex: 1; }

.svc-cat {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(233,30,140,.1); color: #ff6ab4;
    border: 1px solid rgba(233,30,140,.2);
    padding: 4px 11px; border-radius: 999px;
    font-size: .7rem; font-weight: 700;
    margin-bottom: 10px; text-transform: uppercase; letter-spacing: .05em;
}
.svc-name {
    font-size: 1rem; font-weight: 800;
    color: #fff; margin: 0 0 8px;
    line-height: 1.3;
}
.svc-desc {
    font-size: .83rem; color: rgba(255,255,255,.5);
    line-height: 1.65; margin: 0;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}

/* meta row */
.svc-meta {
    display: flex; align-items: center;
    justify-content: space-between;
    gap: 10px; margin-top: 14px;
    padding: 12px 0 0;
    border-top: 1px solid rgba(255,255,255,.06);
}
.svc-price-lbl { font-size: .68rem; color: rgba(255,255,255,.38); text-transform: uppercase; letter-spacing: .08em; margin-bottom: 2px; }
.svc-price-val { font-size: 1rem; font-weight: 800; color: #34d399; }

.svc-dur {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.08);
    border-radius: 10px; padding: 6px 11px;
    font-size: .78rem; font-weight: 600; color: rgba(255,255,255,.65);
    white-space: nowrap;
}
.svc-dur i { color: #e91e8c; }

/* footer */
.svc-footer {
    padding: 12px 18px 16px;
}
.svc-book-btn {
    display: block; text-align: center;
    background: rgba(233,30,140,.12);
    border: 1px solid rgba(233,30,140,.25);
    color: #ff6ab4; text-decoration: none;
    padding: 10px; border-radius: 12px;
    font-weight: 700; font-size: .83rem;
    transition: .22s ease;
}
.svc-book-btn:hover {
    background: linear-gradient(135deg, #e91e8c, #c0156d);
    border-color: #e91e8c;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(233,30,140,.3);
}

/* ── EMPTY ── */
.svc-empty {
    background: rgba(255,255,255,.04);
    border-radius: 24px;
    padding: 60px 30px;
    text-align: center;
    border: 1px solid rgba(233,30,140,.12);
    grid-column: 1 / -1;
}
.svc-empty-icon {
    width: 80px; height: 80px; border-radius: 50%;
    margin: 0 auto 18px;
    background: rgba(233,30,140,.1);
    border: 1px solid rgba(233,30,140,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem; color: #e91e8c;
}
.svc-empty h3 { font-weight: 800; color: #fff; margin-bottom: 10px; }
.svc-empty p  { color: rgba(255,255,255,.5); max-width: 420px; margin: 0 auto 28px; line-height: 1.7; }

</style>

<div class="svc-page">

    {{-- BANNER --}}
    <div class="svc-banner">
        <div>
            <div class="svc-banner-eyebrow">Espace Employé</div>
            <h1 class="svc-banner-title">Mes Services</h1>
            <p class="svc-banner-sub">Consultez les prestations associées à votre profil.</p>
        </div>
        {{-- <a href="{{ route($routePrefix . '.services.create') }}" class="svc-banner-add">
            <i class="fa-solid fa-plus"></i> Ajouter un service
        </a> --}}
    </div>

    {{-- STATS --}}
    <div class="svc-stats">

        <div class="svc-stat svc-stat-total">
            <div class="svc-stat-label">Total services</div>
            <div class="svc-stat-num">{{ $services->count() }}</div>
            <div class="svc-stat-hint">Prestations enregistrées</div>
            <i class="fa-solid fa-layer-group svc-stat-icon"></i>
        </div>

        <div class="svc-stat svc-stat-active">
            <div class="svc-stat-label">Services actifs</div>
            <div class="svc-stat-num">{{ $services->where('is_active', true)->count() }}</div>
            <div class="svc-stat-hint">Disponibles à la réservation</div>
            <i class="fa-solid fa-circle-check svc-stat-icon"></i>
        </div>

        <div class="svc-stat svc-stat-inactive">
            <div class="svc-stat-label">Services inactifs</div>
            <div class="svc-stat-num">{{ $services->where('is_active', false)->count() }}</div>
            <div class="svc-stat-hint">Temporairement indisponibles</div>
            <i class="fa-solid fa-circle-xmark svc-stat-icon"></i>
        </div>

    </div>

    {{-- GRID --}}
    <div class="svc-grid">

        @forelse($services as $service)

            <div class="svc-card">

                {{-- IMAGE --}}
                <div class="svc-img-wrap">

                    @if($service->image)
                        <img src="{{ $service->image_url }}" alt="{{ $service->name }}" loading="lazy">
                    @else
                        <div class="svc-img-placeholder">
                            {{ $service->emoji ?? '✂️' }}
                        </div>
                    @endif

                    <div class="svc-img-overlay"></div>

                    @if($service->is_active)
                        <span class="svc-status svc-status-on">
                            <i class="fa-solid fa-circle-check me-1"></i> Actif
                        </span>
                    @else
                        <span class="svc-status svc-status-off">
                            <i class="fa-solid fa-clock me-1"></i> Inactif
                        </span>
                    @endif

                </div>

                {{-- BODY --}}
                <div class="svc-body">

                    <div class="svc-cat">
                        <i class="fa-solid fa-tag"></i>
                        {{ $service->categorie?->nom ?? 'Beauté & Coiffure' }}
                    </div>

                    <h3 class="svc-name">{{ $service->name }}</h3>

                    @if($service->description)
                        <p class="svc-desc">{{ $service->description }}</p>
                    @endif

                    <div class="svc-meta">
                        <div>
                            <div class="svc-price-lbl">Tarif</div>
                            <div class="svc-price-val">{{ $service->formatted_price }}</div>
                        </div>
                        <div class="svc-dur">
                            <i class="fa-regular fa-clock"></i>
                            {{ $service->formatted_duration }}
                        </div>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="svc-footer">
                    <a href="{{ route($routePrefix . '.services.show', $service) }}"
                       class="svc-book-btn">
                        <i class="fa-solid fa-calendar-check me-2"></i>
                        Voir les réservations
                    </a>
                </div>

            </div>

        @empty

            <div class="svc-empty">
                <div class="svc-empty-icon">
                    <i class="fa-solid fa-scissors"></i>
                </div>
                <h3>Aucun service disponible</h3>
                <p>Aucune prestation n'est encore associée à votre profil employé.</p>
            </div>

        @endforelse

    </div>

</div>

@endsection
