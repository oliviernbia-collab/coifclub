@extends('layouts.home')

@section('title', 'About Us — Marol Hair Braiding')
@section('meta_description', __('messages.about_subtitle'))

@push('styles')
<style>
/* ═══════════════════════════════════════════
   ABOUT PAGE
═══════════════════════════════════════════ */
:root {
    --pink: #e83e8c;
    --pink-dark: #c91a78;
    --dark: #1a1a2e;
    --dark2: #16213e;
}

/* ── Hero ─────────────────────────────── */
.ab-hero {
    position: relative;
    min-height: 520px;
    display: flex;
    align-items: flex-end;
    overflow: hidden;
    background: var(--dark);
}
.ab-hero-bg {
    position: absolute; inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: .28;
}
.ab-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(26,26,46,.92) 0%, rgba(22,33,62,.7) 60%, transparent 100%);
}
.ab-hero-body {
    position: relative;
    padding: 80px 0 64px;
    z-index: 1;
}
.ab-hero-crumb {
    font-size: 12px; color: rgba(255,255,255,.45);
    font-family: 'Inter', sans-serif;
    margin-bottom: 20px;
    display: flex; align-items: center; gap: 6px;
}
.ab-hero-crumb a { color: rgba(255,255,255,.45); text-decoration: none; }
.ab-hero-crumb a:hover { color: var(--pink); }
.ab-hero-crumb i { font-size: 9px; }
.ab-hero-tag {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(232,62,140,.15);
    color: var(--pink); font-size: 11px; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
    padding: 5px 16px; border-radius: 20px;
    border: 1px solid rgba(232,62,140,.25);
    font-family: 'Inter', sans-serif;
    margin-bottom: 18px;
}
.ab-hero-h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2.2rem, 5vw, 3.6rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.1;
    margin: 0 0 18px;
    max-width: 620px;
}
.ab-hero-h1 span { color: var(--pink); }
.ab-hero-sub {
    font-size: 15px; color: rgba(255,255,255,.55);
    font-family: 'Inter', sans-serif; line-height: 1.7;
    max-width: 500px; margin: 0 0 32px;
}
.ab-hero-actions { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
.ab-hero-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: var(--pink); color: #fff;
    padding: 13px 28px; border-radius: 10px;
    font-size: 14px; font-weight: 700;
    text-decoration: none; transition: .22s;
    box-shadow: 0 6px 20px rgba(232,62,140,.4);
    font-family: 'Inter', sans-serif;
}
.ab-hero-btn:hover { background: var(--pink-dark); transform: translateY(-2px); color: #fff; }
.ab-hero-btn-ghost {
    display: inline-flex; align-items: center; gap: 8px;
    color: rgba(255,255,255,.75); font-size: 14px; font-weight: 600;
    text-decoration: none; transition: .2s;
    font-family: 'Inter', sans-serif;
}
.ab-hero-btn-ghost:hover { color: #fff; }

/* ── Stats strip ──────────────────────── */
.ab-stats {
    background: #100a20;
    border-top: 2px solid rgba(232,62,140,.45);
    border-bottom: 2px solid rgba(232,62,140,.45);
    box-shadow: 0 4px 28px rgba(0,0,0,.5), 0 0 0 1px rgba(232,62,140,.1);
}
.ab-stats-inner {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
}
.ab-stat {
    padding: 28px 24px;
    text-align: center;
    border-right: 1px solid rgba(232,62,140,.15);
}
.ab-stat:last-child { border-right: none; }
.ab-stat-num {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem; font-weight: 900;
    color: #fff; line-height: 1;
    margin-bottom: 5px;
}
.ab-stat-num span { color: var(--pink); }
.ab-stat-label {
    font-size: 12.5px; color: rgba(255,255,255,.45); font-weight: 500;
    font-family: 'Inter', sans-serif; letter-spacing: .03em;
}

/* ── Story section ────────────────────── */
.ab-story {
    padding: 96px 0;
    background: #0b0f1e;
}
.ab-story-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 80px;
    align-items: center;
}
.ab-story-img-wrap {
    position: relative;
}
.ab-story-img {
    border-radius: 20px;
    overflow: hidden;
    aspect-ratio: 4/5;
    border: 2px solid rgba(232,62,140,.5);
    box-shadow: 0 12px 50px rgba(0,0,0,.5), 0 0 40px rgba(232,62,140,.15), 0 0 0 1px rgba(232,62,140,.1);
}
.ab-story-img img {
    width: 100%; height: 100%; object-fit: cover; display: block;
}
.ab-story-badge {
    position: absolute;
    bottom: -20px; right: -20px;
    width: 130px; height: 130px;
    border-radius: 50%;
    background: var(--dark);
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    box-shadow: 0 12px 36px rgba(0,0,0,.2);
    border: 4px solid #fff;
}
.ab-story-badge-num {
    font-family: 'Playfair Display', serif;
    font-size: 2rem; font-weight: 900;
    color: var(--pink); line-height: 1;
}
.ab-story-badge-label {
    font-size: 10px; color: rgba(255,255,255,.6);
    font-family: 'Inter', sans-serif;
    text-transform: uppercase; letter-spacing: .1em;
    text-align: center; line-height: 1.3;
    margin-top: 4px;
}
.ab-story-accent {
    position: absolute;
    top: -16px; left: -16px;
    width: 80px; height: 80px;
    border-radius: 50%;
    background: rgba(232,62,140,.12);
    border: 2px solid rgba(232,62,140,.2);
}

/* Story text */
.ab-section-tag {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(232,62,140,.07);
    color: var(--pink); font-size: 11px; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
    padding: 5px 14px; border-radius: 20px;
    font-family: 'Inter', sans-serif;
    margin-bottom: 18px;
}
.ab-section-h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.3rem; font-weight: 800;
    color: #fff; line-height: 1.2;
    margin: 0 0 18px;
}
.ab-section-h2 span { color: var(--pink); }
.ab-section-desc {
    font-size: 15px; color: rgba(255,255,255,.5); line-height: 1.8;
    font-family: 'Inter', sans-serif;
    margin: 0 0 28px;
}
.ab-checklist { display: flex; flex-direction: column; gap: 11px; margin-bottom: 36px; }
.ab-check {
    display: flex; align-items: center; gap: 13px;
    font-size: 14px; color: rgba(255,255,255,.65); font-family: 'Inter', sans-serif;
}
.ab-check-icon {
    width: 24px; height: 24px; border-radius: 50%;
    background: var(--pink); color: #fff; font-size: 10px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; box-shadow: 0 3px 10px rgba(232,62,140,.35);
}

/* ── Values strip ─────────────────────── */
.ab-values {
    padding: 80px 0;
    background: #0b0f1e;
    border-top: 1px solid rgba(232,62,140,.1);
}
.ab-values-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin-top: 48px;
}
.ab-value-card {
    background: rgba(255,255,255,.03);
    border-radius: 18px;
    padding: 32px 28px;
    border: 2px solid rgba(232,62,140,.38);
    transition: .28s;
    position: relative;
    box-shadow: 0 4px 24px rgba(0,0,0,.35), 0 0 0 1px rgba(232,62,140,.06);
}
.ab-value-card::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0;
    height: 3px; border-radius: 18px 18px 0 0;
    background: linear-gradient(90deg, var(--pink), var(--pink-dark));
    transform: scaleX(0); transform-origin: left;
    transition: .3s;
}
.ab-value-card:hover {
    border-color: rgba(232,62,140,.7);
    background: rgba(232,62,140,.05);
    transform: translateY(-5px);
    box-shadow: 0 10px 36px rgba(0,0,0,.4), 0 0 28px rgba(232,62,140,.15), 0 0 0 1px rgba(232,62,140,.1);
}
.ab-value-card:hover::before { transform: scaleX(1); }
.ab-value-icon {
    width: 52px; height: 52px; border-radius: 14px;
    background: rgba(232,62,140,.12); color: var(--pink);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; margin-bottom: 18px;
    border: 1.5px solid rgba(232,62,140,.25);
    box-shadow: 0 4px 12px rgba(232,62,140,.15);
}
.ab-value-card h4 {
    font-family: 'Playfair Display', serif;
    font-size: 1.1rem; font-weight: 700;
    color: #fff; margin: 0 0 10px;
}
.ab-value-card p {
    font-size: 13.5px; color: rgba(255,255,255,.4); line-height: 1.7;
    font-family: 'Inter', sans-serif; margin: 0;
}

/* ── Owner section ────────────────────── */
.ab-owner {
    padding: 96px 0;
    background: var(--dark);
    position: relative;
    overflow: hidden;
}
.ab-owner::before {
    content: '';
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 70% 50%, rgba(232,62,140,.12), transparent 60%);
}
.ab-owner-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 72px;
    align-items: center;
    position: relative; z-index: 1;
}
.ab-owner-img-wrap {
    position: relative;
}
.ab-owner-img {
    border-radius: 20px;
    overflow: hidden;
    aspect-ratio: 3/4;
    box-shadow: 0 24px 60px rgba(0,0,0,.4);
    border: 2px solid rgba(232,62,140,.2);
}
.ab-owner-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
.ab-owner-name-badge {
    position: absolute;
    bottom: 20px; left: 20px; right: 20px;
    background: rgba(10,10,20,.85);
    backdrop-filter: blur(8px);
    border-radius: 12px;
    padding: 14px 18px;
    border: 1px solid rgba(232,62,140,.2);
}
.ab-owner-name { font-family: 'Playfair Display', serif; font-size: 1.1rem; font-weight: 700; color: #fff; margin: 0 0 3px; }
.ab-owner-title { font-size: 12px; color: var(--pink); font-family: 'Inter', sans-serif; font-weight: 600; letter-spacing: .05em; }

.ab-owner-text {}
.ab-owner-tag {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(232,62,140,.15);
    color: var(--pink); font-size: 11px; font-weight: 700;
    letter-spacing: .14em; text-transform: uppercase;
    padding: 5px 16px; border-radius: 20px;
    border: 1px solid rgba(232,62,140,.25);
    font-family: 'Inter', sans-serif;
    margin-bottom: 20px;
}
.ab-owner-h2 {
    font-family: 'Playfair Display', serif;
    font-size: 2.2rem; font-weight: 800;
    color: #fff; line-height: 1.2;
    margin: 0 0 20px;
}
.ab-owner-h2 span { color: var(--pink); }
.ab-owner-quote {
    font-size: 1rem; color: rgba(255,255,255,.6);
    font-family: 'Playfair Display', serif;
    font-style: italic; line-height: 1.8;
    padding-left: 18px;
    border-left: 3px solid var(--pink);
    margin: 0 0 28px;
}
.ab-owner-desc {
    font-size: 14px; color: rgba(255,255,255,.55);
    font-family: 'Inter', sans-serif; line-height: 1.8;
    margin: 0 0 32px;
}
.ab-owner-skills { display: flex; flex-wrap: wrap; gap: 10px; }
.ab-skill-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.06);
    color: rgba(255,255,255,.7);
    font-size: 12.5px; font-weight: 500;
    padding: 7px 16px; border-radius: 20px;
    border: 1px solid rgba(255,255,255,.1);
    font-family: 'Inter', sans-serif;
}
.ab-skill-pill i { color: var(--pink); }

/* ── Contact section ──────────────────── */
.ab-contact {
    padding: 96px 0;
    background: #0b0f1e;
    border-top: 1px solid rgba(232,62,140,.1);
}
.ab-contact-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-top: 48px;
    margin-bottom: 48px;
}
.ab-contact-card {
    background: rgba(255,255,255,.03);
    border: 2px solid rgba(232,62,140,.35);
    border-radius: 18px;
    padding: 28px 22px;
    text-align: center;
    transition: .26s;
    box-shadow: 0 4px 20px rgba(0,0,0,.3), 0 0 0 1px rgba(232,62,140,.06);
}
.ab-contact-card:hover {
    background: rgba(232,62,140,.05);
    border-color: rgba(232,62,140,.65);
    box-shadow: 0 10px 32px rgba(0,0,0,.4), 0 0 24px rgba(232,62,140,.18);
    transform: translateY(-4px);
}
.ab-contact-card-icon {
    width: 54px; height: 54px; border-radius: 14px;
    background: rgba(232,62,140,.12); color: var(--pink);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; margin: 0 auto 16px;
    border: 1.5px solid rgba(232,62,140,.25);
    box-shadow: 0 4px 12px rgba(232,62,140,.15);
    transition: .26s;
}
.ab-contact-card:hover .ab-contact-card-icon {
    background: var(--pink); color: #fff;
    border-color: transparent;
    box-shadow: 0 6px 20px rgba(232,62,140,.45);
}
.ab-contact-card-label {
    font-size: 11px; color: rgba(255,255,255,.35); font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    font-family: 'Inter', sans-serif; margin-bottom: 7px;
}
.ab-contact-card-value {
    font-size: 14px; color: rgba(255,255,255,.78); font-weight: 600;
    font-family: 'Inter', sans-serif; line-height: 1.5;
}

.ab-contact-bottom {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 32px;
    align-items: start;
    background: rgba(255,255,255,.025);
    border: 2px solid rgba(232,62,140,.35);
    border-radius: 22px; padding: 32px;
    box-shadow: 0 4px 28px rgba(0,0,0,.35), 0 0 0 1px rgba(232,62,140,.06);
}
.ab-contact-actions { display: flex; flex-direction: column; gap: 14px; }
.ab-contact-action-title {
    font-family: 'Playfair Display', serif;
    font-size: 1.3rem; font-weight: 700;
    color: #fff; margin: 0 0 20px;
}
.ab-btn-whatsapp {
    display: inline-flex; align-items: center; gap: 10px;
    background: #25d366; color: #fff; padding: 13px 24px;
    border-radius: 10px; font-size: 14px; font-weight: 700;
    text-decoration: none; transition: .2s;
    box-shadow: 0 4px 16px rgba(37,211,102,.3);
    font-family: 'Inter', sans-serif; width: fit-content;
}
.ab-btn-whatsapp:hover { background: #1da851; color: #fff; transform: translateY(-2px); }
.ab-btn-book-dark {
    display: inline-flex; align-items: center; gap: 10px;
    background: var(--dark); color: #fff; padding: 13px 24px;
    border-radius: 10px; font-size: 14px; font-weight: 700;
    text-decoration: none; transition: .2s;
    font-family: 'Inter', sans-serif; width: fit-content;
}
.ab-btn-book-dark:hover { background: var(--pink); color: #fff; transform: translateY(-2px); }

.ab-map-wrap {
    border-radius: 16px;
    overflow: hidden;
    height: 280px;
    border: 2px solid rgba(232,62,140,.4);
    box-shadow: 0 4px 20px rgba(0,0,0,.4), 0 0 16px rgba(232,62,140,.12);
}
.ab-map-wrap iframe { width: 100%; height: 100%; border: none; display: block; }
.ab-map-label {
    font-size: 13px; font-weight: 600; color: rgba(255,255,255,.4);
    font-family: 'Inter', sans-serif;
    margin-bottom: 12px; text-transform: uppercase;
    letter-spacing: .06em;
}

/* ── Section header centered ──────────── */
.ab-section-center { text-align: center; margin-bottom: 0; }
.ab-section-center .ab-section-tag { margin-bottom: 14px; }
.ab-section-center .ab-section-h2 { margin-bottom: 12px; }
.ab-section-center p {
    font-size: 15px; color: rgba(255,255,255,.45); max-width: 540px;
    margin: 0 auto; font-family: 'Inter', sans-serif; line-height: 1.7;
}

/* ── Responsive ───────────────────────── */
@media (max-width: 1199px) {
    .ab-contact-cards { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 991px) {
    .ab-story-grid,
    .ab-owner-grid { grid-template-columns: 1fr; gap: 48px; }
    .ab-story-img { aspect-ratio: 16/9; }
    .ab-owner-img { aspect-ratio: 16/9; }
    .ab-values-grid { grid-template-columns: 1fr; }
    .ab-stats-inner { grid-template-columns: repeat(2, 1fr); }
    .ab-stat:nth-child(2) { border-right: none; }
    .ab-contact-bottom { grid-template-columns: 1fr; }
    .ab-section-h2, .ab-owner-h2 { font-size: 1.8rem; }
    .ab-story-badge { bottom: -10px; right: 10px; width: 100px; height: 100px; }
    .ab-story-badge-num { font-size: 1.6rem; }
}
@media (max-width: 575px) {
    .ab-hero { min-height: 440px; }
    .ab-hero-h1 { font-size: 1.9rem; }
    .ab-contact-cards { grid-template-columns: 1fr; }
    .ab-stats-inner { grid-template-columns: repeat(2, 1fr); }
}
</style>
@endpush

@section('content')

{{-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ --}}
<section class="ab-hero">
    <img src="{{ asset('images/C34.jpg') }}" alt="" class="ab-hero-bg">
    <div class="ab-hero-overlay"></div>
    <div class="container ab-hero-body">
        <div class="ab-hero-crumb">
            <a href="{{ route('home') }}">{{ __('messages.nav_link_home') }}</a>
            <i class="fa-solid fa-chevron-right"></i>
            {{ __('messages.about_breadcrumb') }}
        </div>
        <div class="ab-hero-tag">
            <i class="fa-solid fa-scissors"></i>
            {{ __('messages.about_hero_label') }}
        </div>
        <h1 class="ab-hero-h1">
            {!! __('messages.about_hero_title') !!}
        </h1>
        <p class="ab-hero-sub">{{ __('messages.about_hero_desc') }}</p>
        <div class="ab-hero-actions">
            <a href="{{ route('booking.start') }}" class="ab-hero-btn">
                <i class="fa-regular fa-calendar-check"></i>
                {{ __('messages.nav_btn_book') }}
            </a>
            <a href="#about-contact" class="ab-hero-btn-ghost">
                <i class="fa-solid fa-arrow-down"></i>
                {{ __('messages.about_contact_title') }}
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     STATS STRIP
══════════════════════════════════════ --}}
<div class="ab-stats">
    <div class="container">
        <div class="ab-stats-inner">
            <div class="ab-stat">
                <div class="ab-stat-num">10<span>+</span></div>
                <div class="ab-stat-label">{{ __('messages.about_stat_exp') }}</div>
            </div>
            <div class="ab-stat">
                <div class="ab-stat-num">500<span>+</span></div>
                <div class="ab-stat-label">{{ __('messages.about_stat_clients') }}</div>
            </div>
            <div class="ab-stat">
                <div class="ab-stat-num">4.9<span>★</span></div>
                <div class="ab-stat-label">{{ __('messages.about_stat_rating') }}</div>
            </div>
            <div class="ab-stat">
                <div class="ab-stat-num">30<span>+</span></div>
                <div class="ab-stat-label">{{ __('messages.about_stat_styles') }}</div>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════
     OUR STORY
══════════════════════════════════════ --}}
<section class="ab-story">
    <div class="container">
        <div class="ab-story-grid">

            {{-- Image --}}
            <div class="ab-story-img-wrap">
                <div class="ab-story-accent"></div>
                <div class="ab-story-img">
                    <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair Braiding Salon">
                </div>
                <div class="ab-story-badge">
                    <div class="ab-story-badge-num">10+</div>
                    <div class="ab-story-badge-label">{!! __('messages.about_stat_years_badge') !!}</div>
                </div>
            </div>

            {{-- Text --}}
            <div>
                <div class="ab-section-tag">
                    <i class="fa-solid fa-star"></i>
                    {{ __('messages.about_hero_label') }}
                </div>
                <h2 class="ab-section-h2">
                    {!! __('messages.about_hero_title') !!}
                </h2>
                <p class="ab-section-desc">
                    {{ __('messages.about_hero_desc') }}
                </p>
                <div class="ab-checklist">
                    <div class="ab-check">
                        <div class="ab-check-icon"><i class="fa-solid fa-check"></i></div>
                        {{ __('messages.about_check1') }}
                    </div>
                    <div class="ab-check">
                        <div class="ab-check-icon"><i class="fa-solid fa-check"></i></div>
                        {{ __('messages.about_check2') }}
                    </div>
                    <div class="ab-check">
                        <div class="ab-check-icon"><i class="fa-solid fa-check"></i></div>
                        {{ __('messages.about_check3') }}
                    </div>
                    <div class="ab-check">
                        <div class="ab-check-icon"><i class="fa-solid fa-check"></i></div>
                        {{ __('messages.about_check4') }}
                    </div>
                </div>
                <a href="{{ route('services.index') }}" class="ab-hero-btn" style="width:fit-content;">
                    <i class="fa-solid fa-arrow-right"></i>
                    {{ __('messages.about_view_styles') }}
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     VALUES / WHY CHOOSE US
══════════════════════════════════════ --}}
<section class="ab-values">
    <div class="container">
        <div class="ab-section-center">
            <div class="ab-section-tag" style="margin: 0 auto 14px;">
                <i class="fa-solid fa-heart"></i>
                {{ __('messages.about_why_tag') }}
            </div>
            <h2 class="ab-section-h2">{!! __('messages.about_why_title') !!}</h2>
            <p>{{ __('messages.about_why_desc') }}</p>
        </div>
        <div class="ab-values-grid">
            <div class="ab-value-card">
                <div class="ab-value-icon"><i class="fa-solid fa-bullseye"></i></div>
                <h4>{{ __('messages.pol_mission_title') }}</h4>
                <p>{{ __('messages.pol_mission_text') }}</p>
            </div>
            <div class="ab-value-card">
                <div class="ab-value-icon"><i class="fa-solid fa-eye"></i></div>
                <h4>{{ __('messages.pol_vision_title') }}</h4>
                <p>{{ __('messages.pol_vision_text') }}</p>
            </div>
            <div class="ab-value-card">
                <div class="ab-value-icon"><i class="fa-solid fa-gem"></i></div>
                <h4>{{ __('messages.pol_values_title') }}</h4>
                <p>{{ __('messages.pol_values_text') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     OWNER / TEAM
══════════════════════════════════════ --}}
<section class="ab-owner">
    <div class="container">
        <div class="ab-owner-grid">

            {{-- Image --}}
            <div class="ab-owner-img-wrap">
                <div class="ab-owner-img">
                    <img src="{{ asset('images/MAROL3.jpg') }}" alt="Marol — Founder">
                </div>
                <div class="ab-owner-name-badge">
                    <div class="ab-owner-name">{{ __('messages.about_owner_name') }}</div>
                    <div class="ab-owner-title">{{ __('messages.about_owner_role') }}</div>
                </div>
            </div>

            {{-- Text --}}
            <div class="ab-owner-text">
                <div class="ab-owner-tag">
                    <i class="fa-solid fa-user-tie"></i>
                    {{ __('messages.about_owner_tag') }}
                </div>
                <h2 class="ab-owner-h2">
                    {!! __('messages.about_owner_title') !!}
                </h2>
                <p class="ab-owner-quote">
                    {{ __('messages.about_owner_quote') }}
                </p>
                <p class="ab-owner-desc">
                    {{ __('messages.about_owner_desc') }}
                </p>
                <div class="ab-owner-skills">
                    <span class="ab-skill-pill"><i class="fa-solid fa-check"></i> {{ __('messages.about_skill_knotless') }}</span>
                    <span class="ab-skill-pill"><i class="fa-solid fa-check"></i> {{ __('messages.about_skill_box') }}</span>
                    <span class="ab-skill-pill"><i class="fa-solid fa-check"></i> {{ __('messages.about_skill_cornrows') }}</span>
                    <span class="ab-skill-pill"><i class="fa-solid fa-check"></i> {{ __('messages.about_skill_twists') }}</span>
                    <span class="ab-skill-pill"><i class="fa-solid fa-check"></i> {{ __('messages.about_skill_locs') }}</span>
                    <span class="ab-skill-pill"><i class="fa-solid fa-check"></i> {{ __('messages.about_skill_special') }}</span>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════
     CONTACT
══════════════════════════════════════ --}}
<section class="ab-contact" id="about-contact">
    <div class="container">

        <div class="ab-section-center">
            <div class="ab-section-tag" style="margin: 0 auto 14px;">
                <i class="fa-solid fa-location-dot"></i>
                {{ __('messages.about_contact_title') }}
            </div>
            <h2 class="ab-section-h2">{{ __('messages.about_map_title') }}</h2>
            <p>{{ __('messages.about_contact_subtitle') }}</p>
        </div>

        {{-- Contact cards --}}
        <div class="ab-contact-cards">
            <div class="ab-contact-card">
                <div class="ab-contact-card-icon"><i class="fa-solid fa-phone"></i></div>
                <div class="ab-contact-card-label">{{ __('messages.about_phone_label') }}</div>
                <div class="ab-contact-card-value">+1 (312) 123-4567</div>
            </div>
            <div class="ab-contact-card">
                <div class="ab-contact-card-icon"><i class="fa-solid fa-envelope"></i></div>
                <div class="ab-contact-card-label">{{ __('messages.about_email_label') }}</div>
                <div class="ab-contact-card-value">marolbraids@gmail.com</div>
            </div>
            <div class="ab-contact-card">
                <div class="ab-contact-card-icon"><i class="fa-solid fa-location-dot"></i></div>
                <div class="ab-contact-card-label">{{ __('messages.about_address_label') }}</div>
                <div class="ab-contact-card-value">Chicago, IL, USA</div>
            </div>
            <div class="ab-contact-card">
                <div class="ab-contact-card-icon"><i class="fa-regular fa-clock"></i></div>
                <div class="ab-contact-card-label">{{ __('messages.about_hours_label') }}</div>
                <div class="ab-contact-card-value">
                    {{ __('messages.about_hours_week') }}<br>
                    {{ __('messages.about_hours_sun') }} <span style="color:var(--pink);">{{ __('messages.about_closed') }}</span>
                </div>
            </div>
        </div>

        {{-- Map + actions --}}
        <div class="ab-contact-bottom">
            <div>
                <div class="ab-contact-action-title">{{ __('messages.about_map_title') }} &mdash; <span style="font-size:.9em;font-weight:400;color:rgba(255,255,255,.35);">Chicago, IL</span></div>
                <div class="ab-map-wrap">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d190817.13068538617!2d-87.8439678!3d41.8337652!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880e2c3cd0f4cbed%3A0xafe0a6ad09c0c000!2sChicago%2C%20IL%2C%20USA!5e0!3m2!1sen!2sus!4v1700000000000"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            <div>
                <div class="ab-contact-action-title">{{ __('messages.about_contact_direct') }}</div>
                <p style="font-size:14px;color:rgba(255,255,255,.45);font-family:'Inter',sans-serif;line-height:1.7;margin:0 0 24px;">
                    {{ __('messages.about_contact_direct_desc') }}
                </p>
                <div class="ab-contact-actions">
                    <a href="https://wa.me/13121234567" target="_blank" class="ab-btn-whatsapp">
                        <i class="fa-brands fa-whatsapp"></i>
                        {{ __('messages.about_whatsapp_btn') }}
                    </a>
                    <a href="{{ route('booking.start') }}" class="ab-btn-book-dark">
                        <i class="fa-regular fa-calendar-check"></i>
                        {{ __('messages.nav_btn_book') }}
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
