@extends('layouts.home')

@section('title', 'Our Braiding Styles — Marol Hair Braiding')

@push('styles')
<style>
/* ════════════════════════════════════════════
   BRAIDING STYLES PAGE
════════════════════════════════════════════ */
*, *::before, *::after { box-sizing: border-box; }

/* ── Hero Banner ────────────────────────── */
.bs-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 60%, #0f3460 100%);
    padding: 64px 0 52px;
    position: relative;
    overflow: hidden;
}
.bs-hero::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 70% 50%, rgba(232,62,140,.18) 0%, transparent 65%);
}
.bs-hero::after {
    content: '';
    position: absolute; bottom: -1px; left: 0; right: 0; height: 40px;
    background: #0c0918;
    clip-path: ellipse(55% 100% at 50% 100%);
}
.bs-hero-inner {
    position: relative; z-index: 1;
    max-width: 1200px; margin: 0 auto; padding: 0 40px;
    display: flex; align-items: center; justify-content: space-between; gap: 32px;
}
.bs-hero-text {}
.bs-hero-badge {
    display: inline-flex; align-items: center; gap: 7px;
    background: rgba(232,62,140,.15); border: 1px solid rgba(232,62,140,.3);
    color: #e83e8c; font-size: 11.5px; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    padding: 5px 14px; border-radius: 20px; margin-bottom: 16px;
    font-family: 'Inter', sans-serif;
}
.bs-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: 2.6rem; font-weight: 900;
    color: #fff; margin: 0 0 12px; line-height: 1.15;
}
.bs-hero h1 span { color: #e83e8c; }
.bs-hero-sub {
    font-size: 14.5px; color: rgba(255,255,255,.55);
    font-family: 'Inter', sans-serif; margin: 0 0 28px; line-height: 1.6;
}
.bs-hero-stats {
    display: flex; gap: 28px;
}
.bs-hero-stat { text-align: center; }
.bs-hero-stat-num {
    font-size: 1.6rem; font-weight: 800; color: #fff;
    font-family: 'Playfair Display', serif; line-height: 1;
}
.bs-hero-stat-lbl {
    font-size: 11px; color: rgba(255,255,255,.38);
    font-family: 'Inter', sans-serif; text-transform: uppercase; letter-spacing: .08em;
    margin-top: 3px;
}
/* Hero search */
.bs-hero-search {
    display: flex;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.15);
    border-radius: 12px; overflow: hidden;
    backdrop-filter: blur(8px);
    min-width: 320px;
}
.bs-hero-search input {
    flex: 1; background: transparent; border: none; outline: none;
    padding: 14px 16px; color: #fff; font-size: 14px;
    font-family: 'Inter', sans-serif;
}
.bs-hero-search input::placeholder { color: rgba(255,255,255,.35); }
.bs-hero-search-btn {
    background: #e83e8c; color: #fff; border: none;
    padding: 14px 20px; cursor: pointer; font-size: 15px; transition: .2s;
}
.bs-hero-search-btn:hover { background: #c91a78; }

/* ── Filter bar ─────────────────────────── */
.bs-filterbar {
    background: #0c0918;
    padding: 20px 0;
    position: sticky; top: 68px; z-index: 50;
    border-bottom: 2px solid rgba(232,62,140,.22);
}
.bs-filterbar-inner {
    max-width: 1200px; margin: 0 auto; padding: 0 40px;
}
.bs-filterbar-frame {
    background: rgba(255,255,255,.025);
    border: 2px solid rgba(232,62,140,.38);
    border-radius: 18px; padding: 18px 22px 18px;
    box-shadow: 0 4px 28px rgba(0,0,0,.35), 0 0 0 1px rgba(232,62,140,.07);
}
.bs-filterbar-top {
    display: flex; align-items: center;
    justify-content: space-between; gap: 16px;
    flex-wrap: wrap; margin-bottom: 16px;
}
.bs-results-count {
    font-size: 13px; color: rgba(255,255,255,.45); font-family: 'Inter', sans-serif;
}
.bs-results-count strong { color: #e83e8c; font-weight: 700; }
.bs-sort {
    display: flex; align-items: center; gap: 8px;
    font-size: 13px; color: rgba(255,255,255,.45); font-family: 'Inter', sans-serif;
}
.bs-sort select {
    appearance: none; -webkit-appearance: none; -moz-appearance: none;
    border: 1.5px solid rgba(232,62,140,.35); border-radius: 10px;
    padding: 7px 32px 7px 14px; font-size: 13px; color: rgba(255,255,255,.8);
    background: rgba(255,255,255,.05) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6' fill='none'%3E%3Cpath d='M1 1L5 5L9 1' stroke='%23e83e8c' stroke-width='1.6' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E") no-repeat right 12px center;
    cursor: pointer; outline: none;
    font-family: 'Inter', sans-serif; transition: border-color .2s, background-color .2s;
}
.bs-sort select:hover { border-color: rgba(232,62,140,.55); background-color: rgba(255,255,255,.08); }
.bs-sort select:focus { border-color: rgba(232,62,140,.65); }
.bs-sort select option { background: #1a1235; color: #fff; }

/* Filter pills */
.bs-filters {
    display: flex; flex-wrap: wrap; gap: 8px 10px;
}
.bs-filter-btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 8px 18px; border-radius: 25px;
    border: 1.5px solid rgba(232,62,140,.3);
    background: rgba(255,255,255,.03);
    font-size: 13px; font-weight: 500; color: rgba(255,255,255,.58);
    cursor: pointer; transition: .22s; white-space: nowrap;
    font-family: 'Inter', sans-serif; flex-shrink: 0;
}
.bs-filter-btn:hover {
    border-color: rgba(232,62,140,.68); color: #e83e8c;
    background: rgba(232,62,140,.07);
    box-shadow: 0 0 16px rgba(232,62,140,.12);
}
.bs-filter-btn.active {
    background: #e83e8c; border-color: #e83e8c;
    color: #fff; font-weight: 600;
    box-shadow: 0 4px 16px rgba(232,62,140,.42);
}
.bs-filter-btn .count {
    background: rgba(255,255,255,.12); color: inherit;
    font-size: 11px; font-weight: 700;
    padding: 1px 6px; border-radius: 10px; line-height: 1.4;
}
.bs-filter-btn.active .count { background: rgba(255,255,255,.25); }

/* ── Content area ───────────────────────── */
.bs-body {
    background: #0a0714;
    padding: 36px 0 80px;
}
.bs-body-inner {
    max-width: 1200px; margin: 0 auto; padding: 0 40px;
}

/* ── Cards grid ─────────────────────────── */
.bs-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}

/* Card */
.bs-card {
    background: rgba(255,255,255,.03);
    border: 2px solid rgba(232,62,140,.32);
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.35);
    transition: .3s cubic-bezier(.4,0,.2,1);
    position: relative;
}
.bs-card:hover {
    transform: translateY(-6px);
    border-color: rgba(232,62,140,.68);
    box-shadow: 0 14px 40px rgba(0,0,0,.45), 0 0 28px rgba(232,62,140,.15);
}

/* Card image area */
.bs-card-img {
    position: relative;
    height: 230px;
    overflow: hidden;
}
.bs-card-img img {
    width: 100%; height: 100%;
    object-fit: cover; display: block;
    transition: transform .5s cubic-bezier(.4,0,.2,1);
}
.bs-card:hover .bs-card-img img { transform: scale(1.08); }

/* Hover overlay with Book btn */
.bs-card-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(26,26,46,.75) 0%, transparent 55%);
    display: flex; align-items: flex-end; justify-content: center;
    padding: 0 16px 16px;
    opacity: 0; transition: opacity .3s;
}
.bs-card:hover .bs-card-overlay { opacity: 1; }
.bs-card-overlay-btn {
    display: flex; align-items: center; gap: 7px;
    background: #e83e8c; color: #fff;
    padding: 9px 20px; border-radius: 8px;
    font-size: 13px; font-weight: 700;
    text-decoration: none; transition: .2s;
    font-family: 'Inter', sans-serif;
    width: 100%; justify-content: center;
}
.bs-card-overlay-btn:hover { background: #c91a78; color: #fff; }

/* Category badge */
.bs-card-cat {
    position: absolute; top: 12px; left: 12px;
    background: rgba(26,26,46,.75); backdrop-filter: blur(6px);
    color: rgba(255,255,255,.9); font-size: 10.5px; font-weight: 700;
    letter-spacing: .06em; text-transform: uppercase;
    padding: 4px 10px; border-radius: 6px;
    font-family: 'Inter', sans-serif;
}

/* Duration badge */
.bs-card-duration {
    position: absolute; bottom: 12px; left: 12px;
    background: rgba(255,255,255,.92); backdrop-filter: blur(4px);
    color: #555; font-size: 11px; font-weight: 600;
    padding: 4px 9px; border-radius: 6px;
    display: flex; align-items: center; gap: 5px;
    font-family: 'Inter', sans-serif;
    opacity: 0; transition: opacity .3s;
}
.bs-card:hover .bs-card-duration { opacity: 1; }

/* Heart btn */
.bs-card-heart {
    position: absolute; top: 12px; right: 12px;
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(255,255,255,.92);
    border: none; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    color: #ccc; font-size: 14px;
    box-shadow: 0 2px 8px rgba(0,0,0,.12); transition: .2s;
    backdrop-filter: blur(4px);
}
.bs-card-heart:hover { color: #e83e8c; transform: scale(1.1); }
.bs-card-heart.liked { color: #e83e8c; }

/* Card body */
.bs-card-body { padding: 16px 18px 20px; }
.bs-card-top {
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 8px; margin-bottom: 8px;
}
.bs-card-name {
    font-size: 15px; font-weight: 700; color: #fff;
    font-family: 'Inter', sans-serif; line-height: 1.3;
}
.bs-card-rating {
    display: flex; align-items: center; gap: 3px;
    font-size: 12px; color: #f59e0b; white-space: nowrap;
    flex-shrink: 0;
}
.bs-card-rating span { color: rgba(255,255,255,.3); font-size: 11px; margin-left: 2px; }

.bs-card-desc {
    font-size: 12.5px; color: rgba(255,255,255,.4); line-height: 1.55;
    font-family: 'Inter', sans-serif; margin: 0 0 14px;
    display: -webkit-box; -webkit-line-clamp: 2;
    -webkit-box-orient: vertical; overflow: hidden;
}

.bs-card-footer {
    display: flex; align-items: center;
    justify-content: space-between;
    padding-top: 12px;
    border-top: 1px solid rgba(255,255,255,.06);
}
.bs-card-price {
    font-family: 'Inter', sans-serif;
}
.bs-card-price-from {
    font-size: 10.5px; color: rgba(255,255,255,.3); display: block; font-weight: 500;
    text-transform: uppercase; letter-spacing: .06em;
}
.bs-card-price-val {
    font-size: 17px; font-weight: 800; color: #e83e8c; line-height: 1.1;
}
.bs-card-book {
    display: inline-flex; align-items: center; gap: 6px;
    background: linear-gradient(135deg, #e83e8c, #c0156d);
    color: #fff; border: none;
    padding: 8px 14px; border-radius: 8px;
    font-size: 12.5px; font-weight: 700;
    text-decoration: none; transition: .2s;
    font-family: 'Inter', sans-serif;
    box-shadow: 0 4px 14px rgba(232,62,140,.35);
}
.bs-card-book:hover { box-shadow: 0 6px 20px rgba(232,62,140,.5); color: #fff; transform: translateY(-1px); }

/* Share btn */
.bs-card-share {
    width: 36px; height: 36px; border-radius: 8px;
    background: rgba(255,255,255,.04);
    border: 1.5px solid rgba(232,62,140,.3);
    color: rgba(255,255,255,.5); font-size: 13px;
    display: inline-flex; align-items: center; justify-content: center;
    cursor: pointer; transition: .2s; flex-shrink: 0;
}
.bs-card-share:hover { border-color: rgba(232,62,140,.7); color: #e83e8c; background: rgba(232,62,140,.08); }

/* Card footer actions */
.bs-card-actions { display: flex; align-items: center; gap: 8px; }

/* Toast */
.bs-toast {
    position: fixed; bottom: 28px; left: 50%;
    transform: translateX(-50%) translateY(80px);
    background: #1a0d2e; color: #fff;
    padding: 13px 22px; border-radius: 14px;
    font-size: 13.5px; font-weight: 600;
    font-family: 'Inter', sans-serif;
    z-index: 9999; opacity: 0;
    transition: transform .3s ease, opacity .3s ease;
    white-space: nowrap; pointer-events: none;
    display: flex; align-items: center; gap: 10px;
    border-left: 4px solid #e83e8c;
    box-shadow: 0 8px 32px rgba(0,0,0,.5);
}
.bs-toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
.bs-toast.success { border-left-color: #22c55e; }
.bs-toast.error   { border-left-color: #ef4444; }
.bs-toast.share   { border-left-color: #60a5fa; }

/* ── Empty state ─────────────────────────── */
.bs-empty {
    grid-column: 1/-1; text-align: center;
    padding: 80px 20px; color: rgba(255,255,255,.35); font-family: 'Inter', sans-serif;
}
.bs-empty i { font-size: 3rem; display: block; color: rgba(232,62,140,.3); margin-bottom: 16px; }
.bs-empty p { margin: 0 0 20px; font-size: 15px; color: rgba(255,255,255,.3); }

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */

/* ── ≤1100px ── */
@media (max-width: 1100px) {
    .bs-grid { grid-template-columns: repeat(3, 1fr); }
}

/* ── ≤767px — tablette / mobile ── */
@media (max-width: 767px) {

    /* Hero */
    .bs-hero { padding: 44px 0 40px; }
    .bs-hero-inner { flex-direction: column; align-items: flex-start; padding: 0 18px; gap: 24px; }
    .bs-hero h1 { font-size: 1.75rem; }
    .bs-hero-sub { font-size: 13px; margin-bottom: 20px; }
    .bs-hero-stats { gap: 18px; }
    .bs-hero-stat-num { font-size: 1.3rem; }
    .bs-hero-search { min-width: unset; width: 100%; }

    /* Filterbar */
    .bs-filterbar { top: 56px; }
    .bs-filterbar-inner { padding: 0 14px; }
    .bs-filterbar-frame { padding: 14px 16px 14px; border-radius: 14px; }
    .bs-filterbar-top { gap: 10px; margin-bottom: 12px; }
    .bs-results-count { font-size: 12px; }
    .bs-sort { font-size: 12px; gap: 6px; }
    .bs-sort select { padding: 6px 26px 6px 10px; font-size: 12px; background-position: right 9px center; }
    .bs-filters { gap: 6px 8px; }
    .bs-filter-btn { padding: 6px 14px; font-size: 12px; }

    /* Grid */
    .bs-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .bs-body-inner { padding: 0 14px; }
    .bs-body { padding: 24px 0 60px; }

    /* Card */
    .bs-card-img { height: 180px; }
    .bs-card-body { padding: 12px 13px 14px; }
    .bs-card-name { font-size: 13.5px; }
    .bs-card-desc { font-size: 11.5px; -webkit-line-clamp: 2; margin-bottom: 10px; }
    .bs-card-rating { font-size: 11px; }

    /* Footer : stack prix + actions sur 2 lignes */
    .bs-card-footer { flex-direction: column; align-items: stretch; gap: 8px; padding-top: 10px; }
    .bs-card-price-from { font-size: 9.5px; }
    .bs-card-price-val { font-size: 15px; }
    .bs-card-actions { justify-content: space-between; }
    .bs-card-book {
        flex: 1; justify-content: center;
        font-size: 12px; padding: 8px 10px;
    }
    .bs-card-share { width: 34px; height: 34px; }

    /* Pagination */
    .bs-pagination { margin-top: 28px; }
}

/* ── ≤479px — petit mobile ── */
@media (max-width: 479px) {

    /* Hero */
    .bs-hero h1 { font-size: 1.5rem; }
    .bs-hero-badge { font-size: 10px; padding: 4px 10px; }
    .bs-hero-stats { gap: 12px; }

    /* Filterbar : sort label caché, sélect pleine largeur */
    .bs-sort > span { display: none; }
    .bs-sort select { width: 100%; }
    .bs-filterbar-top { flex-direction: column; align-items: stretch; gap: 8px; }
    .bs-results-count { text-align: center; }

    /* Grid : 1 colonne → footer redevient horizontal */
    .bs-grid { grid-template-columns: 1fr; gap: 14px; }
    .bs-card-img { height: 210px; }
    .bs-card-footer { flex-direction: row; align-items: center; }
    .bs-card-actions { flex-shrink: 0; }
    .bs-card-book { font-size: 13px; padding: 9px 14px; }
}
</style>
@endpush

@section('content')

{{-- ══ HERO ══ --}}
<section class="bs-hero">
    <div class="bs-hero-inner">
        <div class="bs-hero-text">
            <div class="bs-hero-badge">
                <i class="fa-solid fa-scissors"></i>
                {{ __('messages.svc_hero_badge') }}
            </div>
            <h1>{{ __('messages.svc_hero_title') }}</h1>
            <p class="bs-hero-sub">{{ __('messages.svc_hero_sub') }}</p>
            <div class="bs-hero-stats">
                <div class="bs-hero-stat">
                    <div class="bs-hero-stat-num">{{ $services->count() ?: '15+' }}</div>
                    <div class="bs-hero-stat-lbl">{{ __('messages.svc_stat_styles') }}</div>
                </div>
                <div class="bs-hero-stat">
                    <div class="bs-hero-stat-num">5★</div>
                    <div class="bs-hero-stat-lbl">{{ __('messages.svc_stat_rated') }}</div>
                </div>
                <div class="bs-hero-stat">
                    <div class="bs-hero-stat-num">100%</div>
                    <div class="bs-hero-stat-lbl">{{ __('messages.svc_stat_satis') }}</div>
                </div>
            </div>
        </div>

        <div class="bs-hero-search">
            <input type="text" id="searchInput" placeholder="{{ __('messages.svc_search_ph') }}">
            <button class="bs-hero-search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </div>
</section>

{{-- ══ FILTER BAR ══ --}}
<div class="bs-filterbar">
    <div class="bs-filterbar-inner">
        <div class="bs-filterbar-frame">
            <div class="bs-filterbar-top">
                <div class="bs-results-count">
                    {{ __('messages.svc_showing') }} <strong id="countLabel">{{ $services->count() ?: 11 }}</strong> {{ __('messages.svc_showing_sfx') }}
                </div>
                <div class="bs-sort">
                    <span>{{ __('messages.svc_sort_label') }}</span>
                    <select id="sortSelect" onchange="sortCards()">
                        <option value="default">{{ __('messages.svc_sort_featured') }}</option>
                        <option value="price-asc">{{ __('messages.svc_sort_price_asc') }}</option>
                        <option value="price-desc">{{ __('messages.svc_sort_price_desc') }}</option>
                        <option value="name">{{ __('messages.svc_sort_name') }}</option>
                    </select>
                </div>
            </div>

            @php
                $cats = collect($categories ?? [])->filter()->unique()->values();
                $catSlugs = $cats->map(fn($c) => Str::slug($c));
                $defaultFilters = ['Knotless', 'Box Braids', 'Twist', 'Cornrows', 'Special'];
            @endphp
            <div class="bs-filters">
                <button class="bs-filter-btn active" data-filter="all">
                    <i class="fa-solid fa-border-all" style="font-size:11px;"></i>
                    {{ __('messages.svc_all_styles') }}
                </button>
                @foreach($cats as $cat)
                    <button class="bs-filter-btn" data-filter="{{ Str::slug($cat) }}">{{ $cat }}</button>
                @endforeach
                @foreach($defaultFilters as $df)
                    @if(!$catSlugs->contains(Str::slug($df)))
                        <button class="bs-filter-btn" data-filter="{{ Str::slug($df) }}">{{ $df }}</button>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- ══ CARDS ══ --}}
<div class="bs-body">
<div class="bs-body-inner">

    @php
        $fallbacks = [
            'https://images.unsplash.com/photo-1580618672591-eb180b1a973f?q=80&w=600',
            'https://images.unsplash.com/photo-1521590832167-7bcbfaa6381f?q=80&w=600',
            'https://images.unsplash.com/photo-1559599101-f09722fb4948?q=80&w=600',
            'https://images.unsplash.com/photo-1562322140-8baeececf3df?q=80&w=600',
            'https://images.unsplash.com/photo-1487412947147-5cebf100ffc2?q=80&w=600',
            'https://images.unsplash.com/photo-1503104834685-7205e8607eb9?q=80&w=600',
            'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?q=80&w=600',
        ];
        $defaults = [
            ['Knotless Braids', 180, 'knotless', '5-6h', 4.9, 82, 'A protective style gentle on your scalp and long-lasting.'],
            ['Box Braids', 150, 'box-braids', '4-5h', 4.8, 65, 'Classic square-parted braids for a timeless look.'],
            ['Island Twist', 140, 'twist', '3-4h', 4.7, 47, 'Soft two-strand twists for a natural, bohemian finish.'],
            ['Natural Twist', 120, 'twist', '2-3h', 4.8, 38, 'Beautiful natural twists that celebrate your texture.'],
            ['Spring Twist', 130, 'twist', '3-4h', 4.9, 54, 'Springy, lightweight twists with a playful look.'],
            ['Marley Twist', 130, 'twist', '3-4h', 4.6, 29, 'Bold and full twists inspired by natural African hair.'],
            ['French Curls', 120, 'special', '2-3h', 4.7, 33, 'Elegant curled braids perfect for any occasion.'],
            ['Cornrows', 110, 'cornrows', '1-2h', 4.8, 71, 'Sleek and neat flat braids close to the scalp.'],
            ['Tribal Braids', 180, 'knotless', '5-7h', 4.9, 44, 'Intricate tribal patterns for a bold statement look.'],
            ['Lemonade Braids', 150, 'knotless', '4-5h', 4.7, 39, 'Side-swept braids popularized for their chic style.'],
            ['Miracle Knots', 100, 'knotless', '2-3h', 4.8, 26, 'Tiny, invisible-knot braids for the most natural look.'],
        ];
    @endphp

    <div class="bs-grid" id="bsGrid">
        @forelse($services as $svc)
        @php
            $idx = $loop->index % count($fallbacks);
            $img = $svc->image_url ?? $fallbacks[$idx];
            $isFav = in_array($svc->id, $favoriteIds ?? []);
            $catName = optional($svc->categorie)->nom ?? '';
            $catSlug = Str::slug($catName);
            $dur = $svc->formatted_duration ?? '';
            $rating = round($svc->avg_rating ?? 4.8, 1);
            $reviews = $svc->reviews_count ?? 0;
        @endphp
        <div class="bs-card"
             data-cat="{{ $catSlug }}"
             data-price="{{ $svc->price ?? 0 }}"
             data-name="{{ strtolower($svc->name) }}"
             data-search="{{ strtolower($svc->name . ' ' . $catName) }}">
            <div class="bs-card-img">
                <img src="{{ $img }}" alt="{{ $svc->name }}" loading="lazy">
                @if($dur)
                <div class="bs-card-duration"><i class="fa-regular fa-clock"></i> {{ $dur }}</div>
                @endif
                <button class="bs-card-heart {{ $isFav ? 'liked' : '' }}" onclick="toggleHeart(this, {{ $svc->id }})">
                    <i class="{{ $isFav ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                </button>
                <div class="bs-card-overlay">
                    <a href="{{ route('services.show', $svc->id) }}" class="bs-card-overlay-btn">
                        <i class="fa-solid fa-arrow-right"></i> {{ __('messages.svc_view_details') }}
                    </a>
                </div>
            </div>
            <div class="bs-card-body">
                <div class="bs-card-top">
                    <div class="bs-card-name">{{ $svc->name }}</div>
                    @if($rating)
                    <div class="bs-card-rating">
                        <i class="fa-solid fa-star"></i> {{ $rating }}
                        <span>({{ $reviews }})</span>
                    </div>
                    @endif
                </div>
                @if($svc->description)
                <div class="bs-card-desc">{{ $svc->description }}</div>
                @endif
                <div class="bs-card-footer">
                    <div class="bs-card-price">
                        <span class="bs-card-price-from">{{ __('messages.svc_price_from') }}</span>
                        <span class="bs-card-price-val">{{ number_format($svc->price ?? 0) }}</span>
                    </div>
                    <div class="bs-card-actions">
                        <button class="bs-card-share"
                                data-name="{{ $svc->name }}"
                                data-url="{{ route('services.show', $svc->id) }}"
                                onclick="shareService(this)"
                                title="Partager">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                        <a href="{{ route('booking.start', ['service' => $svc->id]) }}" class="bs-card-book">
                            <i class="fa-regular fa-calendar-check"></i> {{ __('messages.svc_book_now') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        {{-- ── Fallback defaults ── --}}
        @foreach($defaults as $i => $d)
        <div class="bs-card"
             data-cat="{{ $d[2] }}"
             data-price="{{ $d[1] }}"
             data-name="{{ strtolower($d[0]) }}"
             data-search="{{ strtolower($d[0] . ' ' . $d[2]) }}">
            <div class="bs-card-img">
                <img src="{{ $fallbacks[$i % count($fallbacks)] }}" alt="{{ $d[0] }}" loading="lazy">
                <div class="bs-card-duration"><i class="fa-regular fa-clock"></i> {{ $d[3] }}</div>
                <button class="bs-card-heart" onclick="toggleHeart(this, 0)">
                    <i class="fa-regular fa-heart"></i>
                </button>
                <div class="bs-card-overlay">
                    <a href="{{ route('booking.start') }}" class="bs-card-overlay-btn">
                        <i class="fa-solid fa-arrow-right"></i> {{ __('messages.svc_view_details') }}
                    </a>
                </div>
            </div>
            <div class="bs-card-body">
                <div class="bs-card-top">
                    <div class="bs-card-name">{{ $d[0] }}</div>
                    <div class="bs-card-rating">
                        <i class="fa-solid fa-star"></i> {{ $d[4] }}
                        <span>({{ $d[5] }})</span>
                    </div>
                </div>
                <div class="bs-card-desc">{{ $d[6] }}</div>
                <div class="bs-card-footer">
                    <div class="bs-card-price">
                        <span class="bs-card-price-from">{{ __('messages.svc_price_from') }}</span>
                        <span class="bs-card-price-val">{{ $d[1] }}</span>
                    </div>
                    <div class="bs-card-actions">
                        <button class="bs-card-share"
                                data-name="{{ $d[0] }}"
                                data-url="{{ route('services.index') }}"
                                onclick="shareService(this)"
                                title="Partager">
                            <i class="fa-solid fa-share-nodes"></i>
                        </button>
                        <a href="{{ route('booking.start') }}" class="bs-card-book">
                            <i class="fa-regular fa-calendar-check"></i> {{ __('messages.svc_book_now') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endforelse
    </div>

</div>
</div>

{{-- Toast --}}
<div class="bs-toast" id="bsToast" role="status" aria-live="polite"></div>

@endsection

@push('scripts')
<script>
/* ── Toast ── */
function bsToast(msg, type = 'info') {
    const t = document.getElementById('bsToast');
    const icons = { success: '<i class="fa-solid fa-circle-check"></i>', error: '<i class="fa-solid fa-circle-xmark"></i>', info: '<i class="fa-solid fa-heart"></i>', share: '<i class="fa-solid fa-link"></i>' };
    t.innerHTML = (icons[type] || '') + ' ' + msg;
    t.className = 'bs-toast show ' + type;
    clearTimeout(t._tid);
    t._tid = setTimeout(() => t.classList.remove('show'), 3000);
}

/* ── Filter by category ── */
document.querySelectorAll('.bs-filter-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.bs-filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        applyFilters();
    });
});

/* ── Live search ── */
document.getElementById('searchInput').addEventListener('input', applyFilters);

function applyFilters() {
    const f = document.querySelector('.bs-filter-btn.active')?.dataset.filter || 'all';
    const q = document.getElementById('searchInput').value.trim().toLowerCase();
    let visible = 0;
    document.querySelectorAll('.bs-card').forEach(card => {
        const cardCat = card.dataset.cat || '';
        const catMatch = f === 'all' || cardCat === f || (cardCat && (cardCat.includes(f) || f.includes(cardCat)));
        const searchMatch = !q || (card.dataset.search || '').includes(q);
        const show = catMatch && searchMatch;
        card.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    const lbl = document.getElementById('countLabel');
    if (lbl) lbl.textContent = visible;
}

/* ── Sort ── */
function sortCards() {
    const val = document.getElementById('sortSelect').value;
    const grid = document.getElementById('bsGrid');
    const cards = [...grid.querySelectorAll('.bs-card')];
    cards.sort((a, b) => {
        if (val === 'price-asc') return +(a.dataset.price||0) - +(b.dataset.price||0);
        if (val === 'price-desc') return +(b.dataset.price||0) - +(a.dataset.price||0);
        if (val === 'name') return (a.dataset.name||'').localeCompare(b.dataset.name||'');
        return 0;
    });
    cards.forEach(c => grid.appendChild(c));
}

/* ── Like / Favoris ── */
function toggleHeart(btn, id) {
    const liked = btn.classList.toggle('liked');
    btn.querySelector('i').className = liked ? 'fa-solid fa-heart' : 'fa-regular fa-heart';

    /* pop animation */
    btn.style.transform = 'scale(1.35)';
    setTimeout(() => btn.style.transform = '', 220);

    if (!id) {
        bsToast(liked ? '{{ __("messages.svc_liked") }}' : '{{ __("messages.svc_unliked") }}', 'info');
        return;
    }

    @auth
    fetch('/favorites/' + id + '/toggle', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(r => {
        if (r.redirected || r.status === 302 || r.status === 401 || r.status === 403) {
            btn.classList.toggle('liked');
            btn.querySelector('i').className = 'fa-regular fa-heart';
            bsToast('{{ __("messages.svc_login_to_like") }}', 'error');
            return;
        }
        bsToast(liked ? '{{ __("messages.svc_liked") }}' : '{{ __("messages.svc_unliked") }}', 'info');
        syncServiceLike(id, liked);
    })
    .catch(() => bsToast(liked ? '{{ __("messages.svc_liked") }}' : '{{ __("messages.svc_unliked") }}', 'info'));
    @else
    /* Non connecté : on annule le toggle visuel et on redirige */
    btn.classList.toggle('liked');
    btn.querySelector('i').className = 'fa-regular fa-heart';
    bsToast('{{ __("messages.svc_login_to_like") }}', 'error');
    setTimeout(() => { window.location.href = '{{ route("login") }}'; }, 1600);
    @endauth
}

/* ── Partager ── */
async function shareService(btn) {
    const name = btn.dataset.name || 'Marol Hair Braiding';
    const url  = btn.dataset.url  || window.location.href;
    const shareData = {
        title: 'Marol Hair Braiding — ' + name,
        text:  '✂️ Découvrez « ' + name + ' » chez Marol Hair Braiding !',
        url:   url,
    };

    if (navigator.share && navigator.canShare && navigator.canShare(shareData)) {
        try { await navigator.share(shareData); } catch (_) {}
        return;
    }

    try {
        await navigator.clipboard.writeText(url);
        bsToast('Lien copié dans le presse-papier !', 'share');
    } catch (_) {
        bsToast('Lien : ' + url, 'share');
    }
}
</script>
@endpush
