@extends('layouts.app')

@section('title', 'Offres du Mois')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>
:root {
    --gold:    #D4AF37;
    --gold-lt: #f6e27a;
    --gold-dim:rgba(212,175,55,.12);
    --dark:    #0b0f19;
    --dark2:   #111827;
    --muted:   #6b7280;
    --ease:    cubic-bezier(.4,0,.2,1);
}

body { background: #0e0a1c; color: rgba(255,255,255,.85); }

/* ── HERO ─────────────────────────────────────────────────── */
.offers-hero {
    position: relative;
    overflow: hidden;
    border-radius: 0 0 40px 40px;
    margin-bottom: 56px;
    background: linear-gradient(135deg, #0b0f19 0%, #1a1400 55%, #0f1624 100%);
    padding: 80px 24px 72px;
    text-align: center;
}
.offers-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 65% 50% at 50% 0%, rgba(212,175,55,.18), transparent),
        radial-gradient(ellipse 35% 45% at 85% 85%, rgba(212,175,55,.07), transparent);
    pointer-events: none;
}
.oh-eyebrow {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 18px;
    border-radius: 99px;
    border: 1px solid rgba(212,175,55,.3);
    background: rgba(212,175,55,.08);
    color: var(--gold);
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    margin-bottom: 20px;
}
.offers-hero h1 {
    position: relative;
    font-size: clamp(2.2rem, 5vw, 3.4rem);
    font-weight: 800;
    color: #f5ead8;
    line-height: 1.1;
    margin-bottom: 14px;
    letter-spacing: -.01em;
}
.offers-hero h1 span {
    background: linear-gradient(135deg, var(--gold), var(--gold-lt));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.offers-hero p {
    position: relative;
    color: rgba(245,234,216,.5);
    font-size: 1rem;
    max-width: 480px;
    margin: 0 auto;
    line-height: 1.75;
}

/* ── GRID ─────────────────────────────────────────────────── */
.offers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 28px;
}

/* ── OFFER CARD ───────────────────────────────────────────── */
.offer-card {
    background: white;
    border-radius: 24px;
    overflow: hidden;
    border: 1px solid rgba(212,175,55,.1);
    box-shadow: 0 4px 24px rgba(0,0,0,.06);
    transition: transform .35s var(--ease), box-shadow .35s var(--ease), border-color .25s;
    display: flex;
    flex-direction: column;
}
.offer-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 22px 56px rgba(0,0,0,.12);
    border-color: rgba(212,175,55,.3);
}

/* Image */
.offer-img-wrap {
    position: relative;
    height: 240px;
    overflow: hidden;
    flex-shrink: 0;
}
.offer-img-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform .6s var(--ease);
}
.offer-card:hover .offer-img-wrap img { transform: scale(1.06); }
.offer-img-wrap::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(11,15,25,.55) 0%, transparent 55%);
}

/* Discount badge */
.offer-discount {
    position: absolute;
    top: 16px; right: 16px;
    z-index: 2;
    background: linear-gradient(135deg, var(--gold), var(--gold-lt));
    color: #111827;
    padding: 8px 16px;
    border-radius: 99px;
    font-size: 13px;
    font-weight: 900;
    letter-spacing: .5px;
    box-shadow: 0 6px 20px rgba(212,175,55,.35);
}

/* Limited badge */
.offer-limited {
    position: absolute;
    top: 16px; left: 16px;
    z-index: 2;
    background: rgba(11,15,25,.72);
    backdrop-filter: blur(8px);
    color: rgba(245,234,216,.9);
    padding: 5px 13px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 600;
    border: 1px solid rgba(212,175,55,.2);
}

/* Body */
.offer-body {
    padding: 26px 24px 22px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.offer-title {
    font-size: 1.2rem;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 10px;
    letter-spacing: -.01em;
    line-height: 1.3;
}
.offer-desc {
    color: var(--muted);
    font-size: .88rem;
    line-height: 1.75;
    flex: 1;
    margin-bottom: 22px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Divider */
.offer-divider {
    height: 1px;
    background: linear-gradient(to right, transparent, rgba(212,175,55,.18), transparent);
    margin-bottom: 20px;
}

/* CTA */
.offer-cta {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.offer-validity {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: var(--muted);
    font-weight: 500;
}
.offer-validity i { color: var(--gold); font-size: 11px; }

.btn-offer {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: linear-gradient(135deg, var(--dark2), #0b0f19);
    color: var(--gold-lt);
    padding: 11px 20px;
    border-radius: 14px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    border: 1px solid rgba(212,175,55,.2);
    transition: all .25s var(--ease);
    box-shadow: 0 4px 16px rgba(0,0,0,.14);
    white-space: nowrap;
}
.btn-offer i { font-size: 11px; transition: transform .25s; }
.btn-offer:hover {
    background: linear-gradient(135deg, var(--gold), var(--gold-lt));
    color: #111827;
    border-color: transparent;
    box-shadow: 0 8px 24px rgba(212,175,55,.32);
    transform: translateY(-1px);
}
.btn-offer:hover i { transform: translateX(3px); color: #111827; }

/* Empty state */
.offers-empty {
    text-align: center;
    padding: 80px 32px;
    background: white;
    border-radius: 28px;
    border: 1px solid rgba(212,175,55,.12);
    box-shadow: 0 8px 32px rgba(0,0,0,.05);
    grid-column: 1/-1;
}
.offers-empty-icon {
    width: 88px; height: 88px;
    border-radius: 50%;
    background: var(--gold-dim);
    border: 1px solid rgba(212,175,55,.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 22px;
    font-size: 34px;
    color: var(--gold);
}
.offers-empty h3 { font-weight: 800; font-size: 1.45rem; color: #1a1a2e; margin-bottom: 10px; }
.offers-empty p  { color: var(--muted); }

@media (max-width: 768px) {
    .offers-hero  { padding: 60px 20px 52px; border-radius: 0 0 28px 28px; }
    .offers-grid  { grid-template-columns: 1fr; }
}
</style>

{{-- HERO --}}
<div class="offers-hero">
    <div class="oh-eyebrow">
        <i class="fa-solid fa-tag"></i>
        Offres Exclusives
    </div>
    <h1>Offres du <span>Mois</span></h1>
    <p>Profitez de nos promotions exclusives beauté &amp; coiffure, disponibles pour une durée limitée.</p>
</div>

<div class="container pb-5">

    <div class="offers-grid">

        @forelse($offers as $offer)

            <div class="offer-card">

                <div class="offer-img-wrap">
                    <img src="{{ $offer['image'] }}" alt="{{ $offer['title'] }}" loading="lazy">

                    @if(!empty($offer['discount']))
                        <span class="offer-discount">{{ $offer['discount'] }}</span>
                    @endif

                    <span class="offer-limited">
                        <i class="fa-solid fa-fire" style="color:#f59e0b;margin-right:4px;"></i>
                        Offre limitée
                    </span>
                </div>

                <div class="offer-body">
                    <h3 class="offer-title">{{ $offer['title'] }}</h3>
                    <p class="offer-desc">{{ $offer['description'] }}</p>

                    <div class="offer-divider"></div>

                    <div class="offer-cta">
                        <div class="offer-validity">
                            <i class="fa-regular fa-clock"></i>
                            Durée limitée
                        </div>
                        <a href="{{ route('services.index') }}" class="btn-offer">
                            Réserver <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>

        @empty

            <div class="offers-empty">
                <div class="offers-empty-icon">
                    <i class="fa-solid fa-tag"></i>
                </div>
                <h3>Aucune offre disponible</h3>
                <p>De nouvelles promotions seront bientôt disponibles.</p>
            </div>

        @endforelse

    </div>

</div>

@endsection
