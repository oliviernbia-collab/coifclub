@extends('layouts.app')

@section('title', __('messages.gallery') . ' — Marol Hair Braiding')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,500;1,600&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>
/* ═══════════════════════════════════════
   GALLERY PAGE — PREMIUM DARK THEME
═══════════════════════════════════════ */
:root {
    --gp: #e91e8c;
    --gp-dark: #c91a78;
    --gbg: #0e0a1c;
    --gcard: #1a1130;
    --gcard2: #120e22;
    --gborder: rgba(255,255,255,.06);
    --gborder-pk: rgba(233,30,140,.15);
    --gmuted: rgba(255,255,255,.6);
}

body { background: var(--gbg) !important; color: #fff; }

/* ─── HERO ─── */
.gp-hero {
    position: relative;
    min-height: 440px;
    display: flex;
    align-items: flex-end;
    overflow: hidden;
}

.gp-hero-bg {
    position: absolute;
    inset: 0;
    background-image: url('{{ asset('images/C00.jpg') }}');
    background-size: cover;
    background-position: center top;
    transform: scale(1.04);
    transition: transform 8s ease;
}
.gp-hero:hover .gp-hero-bg { transform: scale(1.0); }

.gp-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        90deg,
        rgba(14,10,28,.97) 0%,
        rgba(14,10,28,.78) 50%,
        rgba(14,10,28,.30) 100%
    );
}

.gp-hero-body {
    position: relative;
    z-index: 2;
    padding: clamp(28px, 6vw, 60px) clamp(20px, 6vw, 60px) clamp(28px, 5vw, 56px);
    max-width: 680px;
}

.gp-eyebrow {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: var(--gp);
    margin-bottom: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.gp-eyebrow::before { content: '✦'; font-size: .55rem; }

.gp-hero-title {
    font-size: clamp(2.2rem, 4.5vw, 3.4rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.08;
    margin: 0 0 6px;
}

.gp-hero-cursive {
    display: block;
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 600;
    color: var(--gp);
    margin-bottom: 16px;
}

.gp-hero-sub {
    color: rgba(255,255,255,.75);
    font-size: .95rem;
    line-height: 1.65;
    margin-bottom: 28px;
    max-width: 480px;
}

/* ─── FILTER PILLS ─── */
.gp-filters-wrap {
    background: rgba(14,10,28,.85);
    backdrop-filter: blur(12px);
    border-top: 1px solid var(--gborder-pk);
    border-bottom: 1px solid var(--gborder);
    padding: 16px clamp(16px, 6vw, 60px);
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
}

.gp-filter-label {
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .14em;
    color: var(--gmuted);
    margin-right: 6px;
    white-space: nowrap;
}

.gp-filter {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.7);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 999px;
    padding: 8px 18px;
    font-size: .82rem;
    font-weight: 600;
    cursor: pointer;
    transition: .22s ease;
    font-family: 'Inter', sans-serif;
    white-space: nowrap;
}

.gp-filter .gp-count {
    background: rgba(255,255,255,.12);
    border-radius: 999px;
    padding: 1px 7px;
    font-size: .68rem;
}

.gp-filter:hover {
    background: rgba(233,30,140,.14);
    border-color: rgba(233,30,140,.35);
    color: #fff;
}

.gp-filter.active {
    background: linear-gradient(135deg, var(--gp), var(--gp-dark));
    color: #fff;
    border-color: transparent;
    box-shadow: 0 4px 16px rgba(233,30,140,.3);
}

.gp-filter.active .gp-count {
    background: rgba(255,255,255,.22);
}

/* ─── SECTION HEADER ─── */
.gp-section-head {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 28px;
}

.gp-section-ttl {
    font-size: 1.55rem;
    font-weight: 800;
    color: #fff;
    white-space: nowrap;
}

.gp-section-em {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    color: var(--gp);
    font-weight: 600;
}

.gp-section-line {
    flex: 1;
    height: 3px;
    background: linear-gradient(90deg, var(--gp), transparent);
    border-radius: 2px;
    margin-left: 4px;
}

/* ─── STATS BAR ─── */
.gp-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    padding: clamp(18px, 3vw, 28px) clamp(16px, 6vw, 60px);
    background: var(--gcard2);
    border-bottom: 1px solid var(--gborder);
}

.gp-stat {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 18px;
    background: var(--gcard);
    border-radius: 16px;
    border: 1px solid var(--gborder-pk);
}

.gp-stat-icon {
    width: 42px; height: 42px;
    background: rgba(233,30,140,.12);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gp);
    font-size: 1rem;
    flex-shrink: 0;
}

.gp-stat-num {
    font-size: 1.45rem;
    font-weight: 900;
    color: #fff;
    line-height: 1;
}

.gp-stat-lbl {
    font-size: .7rem;
    color: var(--gmuted);
    margin-top: 3px;
}

/* ─── GRID WRAPPER ─── */
.gp-grid-wrap {
    padding: clamp(24px, 4vw, 44px) clamp(16px, 6vw, 60px) clamp(32px, 5vw, 56px);
    background: var(--gbg);
}

/* ─── PORTRAIT CARD GRID ─── */
.gp-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

/* ─── STYLE CARD ─── */
.gp-card {
    border-radius: 20px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    transition: transform .35s ease, box-shadow .35s ease;
    border: 1px solid var(--gborder);
    background: var(--gcard);
}

.gp-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 24px 56px rgba(233,30,140,.25);
    border-color: rgba(233,30,140,.3);
}

.gp-card.hidden { display: none; }

.gp-card-img {
    width: 100%;
    height: 300px;
    object-fit: cover;
    display: block;
    transition: transform .5s ease;
}

.gp-card-placeholder {
    width: 100%;
    height: 300px;
    background: linear-gradient(135deg, #2d1060, #1a0a2e);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
}

.gp-card:hover .gp-card-img {
    transform: scale(1.06);
}

.gp-card-overlay {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: linear-gradient(transparent 0%, rgba(14,10,28,.92) 60%);
    padding: 55px 16px 18px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.gp-card-badge {
    position: absolute;
    top: 12px; left: 12px;
    background: linear-gradient(135deg, var(--gp), var(--gp-dark));
    color: #fff;
    font-size: .65rem;
    font-weight: 700;
    padding: 4px 11px;
    border-radius: 999px;
    text-transform: uppercase;
    letter-spacing: .07em;
    z-index: 2;
}

.gp-card-name {
    color: #fff;
    font-weight: 800;
    font-size: .95rem;
    line-height: 1.3;
    margin: 0;
}

.gp-card-meta {
    display: flex;
    align-items: center;
    gap: 14px;
    font-size: .76rem;
    color: rgba(255,255,255,.6);
}

.gp-card-meta i { color: var(--gp); margin-right: 3px; }
.gp-card-price { color: rgba(255,255,255,.85); font-weight: 700; }

.gp-card-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    background: var(--gp);
    color: #fff;
    text-decoration: none;
    padding: 10px 14px;
    border-radius: 12px;
    font-weight: 700;
    font-size: .8rem;
    transition: .22s ease;
    border: none;
    cursor: pointer;
}

.gp-card-btn:hover {
    background: var(--gp-dark);
    color: #fff;
    transform: translateY(-2px);
}

/* ─── EMPTY STATE ─── */
.gp-empty {
    grid-column: 1 / -1;
    text-align: center;
    color: rgba(255,255,255,.35);
    padding: 80px 20px;
}

.gp-empty i {
    font-size: 3.5rem;
    display: block;
    margin-bottom: 18px;
    color: rgba(233,30,140,.35);
}

/* ─── HORIZONTAL SCROLL (slider) ─── */
.gp-carousel-wrap {
    padding: 0 clamp(16px, 6vw, 60px) clamp(28px, 4vw, 48px);
    background: var(--gbg);
}

.gp-carousel {
    display: flex;
    gap: 16px;
    overflow-x: auto;
    padding-bottom: 6px;
    scrollbar-width: none;
}
.gp-carousel::-webkit-scrollbar { display: none; }

.gp-slide-card {
    flex: 0 0 200px;
    border-radius: 18px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    transition: .3s;
    border: 1px solid var(--gborder);
}
.gp-slide-card:hover { transform: translateY(-6px); box-shadow: 0 16px 40px rgba(233,30,140,.22); }

.gp-slide-card img {
    width: 100%;
    height: 260px;
    object-fit: cover;
    display: block;
}

.gp-slide-info {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: linear-gradient(transparent, rgba(14,10,28,.9));
    padding: 35px 12px 14px;
    text-align: center;
}

.gp-slide-name {
    color: #fff;
    font-weight: 700;
    font-size: .82rem;
    margin-bottom: 8px;
}

.gp-slide-btn {
    display: inline-block;
    background: var(--gp);
    color: #fff;
    padding: 5px 16px;
    border-radius: 50px;
    font-size: .72rem;
    font-weight: 700;
    text-decoration: none;
    transition: .2s;
}
.gp-slide-btn:hover { background: var(--gp-dark); color: #fff; }

/* ─── CTA SECTION ─── */
.gp-cta {
    margin: 0 clamp(16px, 6vw, 60px) clamp(36px, 5vw, 60px);
    background: linear-gradient(135deg, #1a0a2e 0%, #2d1060 50%, #1a0535 100%);
    border: 1px solid var(--gborder-pk);
    border-radius: 28px;
    padding: clamp(28px, 5vw, 52px) clamp(20px, 5vw, 60px);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 32px;
    flex-wrap: wrap;
    position: relative;
    overflow: hidden;
}

.gp-cta::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 70% 50%, rgba(233,30,140,.12), transparent 60%);
    pointer-events: none;
}

.gp-cta-text {
    position: relative;
    z-index: 1;
}

.gp-cta-eyebrow {
    font-size: .72rem;
    font-weight: 700;
    letter-spacing: .16em;
    text-transform: uppercase;
    color: var(--gp);
    margin-bottom: 10px;
}

.gp-cta-title {
    font-size: 1.6rem;
    font-weight: 900;
    color: #fff;
    margin: 0 0 8px;
    line-height: 1.2;
}

.gp-cta-em {
    font-family: 'Cormorant Garamond', serif;
    font-style: italic;
    color: var(--gp);
}

.gp-cta-sub {
    color: rgba(255,255,255,.65);
    font-size: .93rem;
    margin: 0;
}

.gp-cta-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}

.gp-btn-pk {
    background: var(--gp);
    color: #fff;
    border: none;
    padding: 14px 28px;
    border-radius: 50px;
    font-weight: 700;
    font-size: .9rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 9px;
    transition: .3s;
    box-shadow: 0 8px 24px rgba(233,30,140,.4);
    cursor: pointer;
    white-space: nowrap;
}
.gp-btn-pk:hover { background: var(--gp-dark); color: #fff; transform: translateY(-2px); }

.gp-btn-ol {
    background: transparent;
    color: #fff;
    border: 1.5px solid rgba(255,255,255,.3);
    padding: 14px 28px;
    border-radius: 50px;
    font-weight: 600;
    font-size: .9rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 9px;
    transition: .3s;
    white-space: nowrap;
}
.gp-btn-ol:hover { border-color: var(--gp); color: var(--gp); }

/* ─── RESPONSIVE ─── */
@media (max-width: 1100px) {
    .gp-grid { grid-template-columns: repeat(3, 1fr); }
    .gp-stats { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 768px) {
    .gp-hero-body { padding: 40px 24px 40px; }
    .gp-filters-wrap { padding: 14px 20px; }
    .gp-stats { padding: 20px 20px; }
    .gp-grid-wrap { padding: 28px 20px 40px; }
    .gp-carousel-wrap { padding: 0 20px 36px; }
    .gp-grid { grid-template-columns: repeat(2, 1fr); gap: 14px; }
    .gp-cta { margin: 0 20px 40px; padding: 36px 28px; }
}

@media (max-width: 480px) {
    .gp-grid { grid-template-columns: 1fr; }
    .gp-stats { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 360px) {
    .gp-stats { grid-template-columns: 1fr; }
    .gp-cta { border-radius: 18px; }
    .gp-filter-pill { font-size: .72rem; padding: 6px 12px; }
}
</style>

{{-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ --}}
<div class="gp-hero">
    <div class="gp-hero-bg"></div>
    <div class="gp-hero-overlay"></div>
    <div class="gp-hero-body">
        <div class="gp-eyebrow">{{ __('messages.gallery') }}</div>
        <h1 class="gp-hero-title">{{ __('messages.gallery') }}</h1>
        <span class="gp-hero-cursive">{{ __('messages.recommended_styles') }}</span>
        <p class="gp-hero-sub">{{ __('messages.discover_services') }}</p>
        <div style="display:flex;gap:12px;flex-wrap:wrap;">
            <a href="{{ route('booking.start') }}" class="gp-btn-pk">
                <i class="fa-solid fa-calendar-check"></i>
                {{ __('messages.book_appointment') }}
            </a>
            <a href="{{ route('services.index') }}" class="gp-btn-ol">
                <i class="fa-solid fa-scissors"></i>
                {{ __('messages.our_services') }}
            </a>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     STATS BAR
══════════════════════════════════════ --}}
<div class="gp-stats">
    <div class="gp-stat">
        <div class="gp-stat-icon"><i class="fa-solid fa-images"></i></div>
        <div>
            <div class="gp-stat-num">{{ $services->count() }}+</div>
            <div class="gp-stat-lbl">{{ __('messages.our_services') }}</div>
        </div>
    </div>
    <div class="gp-stat">
        <div class="gp-stat-icon"><i class="fa-solid fa-tags"></i></div>
        <div>
            <div class="gp-stat-num">{{ $categories->count() }}</div>
            <div class="gp-stat-lbl">{{ __('messages.categories') }}</div>
        </div>
    </div>
    <div class="gp-stat">
        <div class="gp-stat-icon"><i class="fa-solid fa-star"></i></div>
        <div>
            <div class="gp-stat-num">5.0</div>
            <div class="gp-stat-lbl">{{ __('messages.style_recommendations') }}</div>
        </div>
    </div>
    <div class="gp-stat">
        <div class="gp-stat-icon"><i class="fa-solid fa-scissors"></i></div>
        <div>
            <div class="gp-stat-num">200+</div>
            <div class="gp-stat-lbl">{{ __('messages.recommended_styles') }}</div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     FILTER PILLS
══════════════════════════════════════ --}}
<div class="gp-filters-wrap">
    <span class="gp-filter-label"><i class="fa-solid fa-sliders"></i> {{ __('messages.categories') }}</span>
    <button class="gp-filter active" data-filter="all">
        <i class="fa-solid fa-th-large"></i>
        {{ __('messages.promotion_filter_all') }}
        <span class="gp-count">{{ $services->count() }}</span>
    </button>
    @foreach($categories as $cat)
        @php $catCount = $services->filter(fn($s) => $s->categorie?->id === $cat->id)->count(); @endphp
        @if($catCount > 0)
        <button class="gp-filter" data-filter="{{ Str::slug($cat->nom) }}">
            {{ $cat->nom }}
            <span class="gp-count">{{ $catCount }}</span>
        </button>
        @endif
    @endforeach
</div>

{{-- ══════════════════════════════════════
     FEATURED CAROUSEL (top 6 with image)
══════════════════════════════════════ --}}
@php
    $featured = $services->filter(fn($s) => $s->image)->take(8);
@endphp

@if($featured->count() > 0)
<div class="gp-carousel-wrap" style="padding-top:44px;">
    <div style="padding:0 0 20px;display:flex;align-items:center;gap:12px;">
        <span class="gp-section-ttl">{{ __('messages.recommended_styles') }} <span class="gp-section-em">{{ __('messages.style_recommendations') }}</span></span>
        <span class="gp-section-line"></span>
    </div>
    <div class="gp-carousel" id="gpCarousel">
        @foreach($featured as $service)
        <div class="gp-slide-card">
            <img src="{{ $service->image_url }}" alt="{{ $service->name }}" loading="lazy">
            <div class="gp-slide-info">
                <div class="gp-slide-name">{{ $service->name }}</div>
                <a href="{{ route('booking.start') }}?service={{ $service->id }}" class="gp-slide-btn">
                    {{ __('messages.nh_book') }}
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- ══════════════════════════════════════
     MAIN GRID
══════════════════════════════════════ --}}
<div class="gp-grid-wrap">

    <div style="display:flex;align-items:center;gap:12px;margin-bottom:28px;">
        <span class="gp-section-ttl">{{ __('messages.our_services') }} <span class="gp-section-em">{{ __('messages.gallery') }}</span></span>
        <span class="gp-section-line"></span>
        <span style="font-size:.75rem;color:var(--gmuted);white-space:nowrap;" id="gpCount">
            {{ $services->count() }} {{ __('messages.our_services') }}
        </span>
    </div>

    <div class="gp-grid" id="galGrid">

        @forelse($services as $service)
        <div class="gp-card" data-cat="{{ Str::slug($service->categorie?->nom ?? '') }}">

            @if($service->image)
                <img src="{{ $service->image_url }}"
                     alt="{{ $service->name }}"
                     class="gp-card-img"
                     loading="lazy">
            @else
                <div class="gp-card-placeholder">
                    {{ $service->emoji ?? '✂️' }}
                </div>
            @endif

            <div class="gp-card-overlay">
                <h3 class="gp-card-name">{{ $service->name }}</h3>
                <div class="gp-card-meta">
                    <span><i class="fa-regular fa-clock"></i>{{ $service->formatted_duration }}</span>
                </div>
                <a href="{{ route('booking.start') }}?service={{ $service->id }}"
                   class="gp-card-btn">
                    <i class="fa-solid fa-calendar-check"></i>
                    {{ __('messages.book_appointment') }}
                </a>
            </div>

        </div>
        @empty
        <div class="gp-empty">
            <i class="fa-solid fa-images"></i>
            <p>{{ __('messages.no_slots_alert') }}</p>
        </div>
        @endforelse

    </div>
</div>

{{-- ══════════════════════════════════════
     CTA SECTION
══════════════════════════════════════ --}}
<div class="gp-cta">
    <div class="gp-cta-text">
        <div class="gp-cta-eyebrow">✦ Marol Hair Braiding · {{ __('messages.nav_tagline') }}</div>
        <h2 class="gp-cta-title">
            {{ __('messages.nh_bk_title') }} <span class="gp-cta-em">{{ __('messages.nh_bk_em') }}</span>
        </h2>
        <p class="gp-cta-sub">{{ __('messages.nh_bk_sub') }}</p>
    </div>
    <div class="gp-cta-actions">
        <a href="{{ route('booking.start') }}" class="gp-btn-pk">
            <i class="fa-solid fa-calendar-check"></i>
            {{ __('messages.nh_btn_rdv') }}
        </a>
        <a href="{{ route('stylists.index') }}" class="gp-btn-ol">
            <i class="fa-solid fa-star"></i>
            {{ __('messages.stylists') }}
        </a>
    </div>
</div>

<script>
(function () {

    const btns  = document.querySelectorAll('.gp-filter');
    const cards = document.querySelectorAll('.gp-card');
    const counter = document.getElementById('gpCount');

    function updateCounter() {
        const visible = document.querySelectorAll('.gp-card:not(.hidden)').length;
        if (counter) counter.textContent = visible + ' {{ __('messages.our_services') }}';
    }

    btns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            btns.forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');

            const filter = btn.dataset.filter;

            cards.forEach(function (card) {
                if (filter === 'all' || card.dataset.cat === filter) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });

            updateCounter();
        });
    });

}());
</script>

@endsection
