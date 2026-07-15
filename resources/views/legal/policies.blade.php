@extends('layouts.home')

@section('title', __('messages.pol_breadcrumb') . ' — Marol Hair Braiding')

@push('styles')
<style>
:root { --pink: #e83e8c; --pink-dark: #c91a78; }

/* ── Hero ── */
.pol-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    padding: 80px 0 56px; text-align: center;
    position: relative; overflow: hidden;
}
.pol-hero::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse 60% 50% at 50% 0%, rgba(232,62,140,.14), transparent);
    pointer-events: none;
}
.pol-eyebrow {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(232,62,140,.1); border: 1px solid rgba(232,62,140,.2);
    color: #ff6ab4; font-size: .72rem; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    padding: 5px 14px; border-radius: 50px; margin-bottom: 16px;
    font-family: 'Inter', sans-serif; position: relative;
}
.pol-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-weight: 900; color: #fff; margin-bottom: 10px; position: relative;
}
.pol-hero h1 span { color: var(--pink); }
.pol-hero-sub {
    color: rgba(255,255,255,.4); font-size: .9rem;
    font-family: 'Inter', sans-serif; position: relative;
}

/* ── Breadcrumb ── */
.pol-crumb {
    font-size: 12.5px; color: rgba(255,255,255,.3);
    padding: 18px 0 0; font-family: 'Inter', sans-serif;
}
.pol-crumb a { color: rgba(255,255,255,.3); text-decoration: none; transition: color .18s; }
.pol-crumb a:hover { color: var(--pink); }
.pol-crumb span { color: var(--pink); margin: 0 6px; }

/* ── Body ── */
.pol-body-wrap { background: #0b0f1e; padding: 64px 0 100px; }
.pol-container { max-width: 820px; margin: 0 auto; padding: 0 24px; }

/* ── Table des matières ── */
.pol-toc {
    background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.07);
    border-radius: 18px; padding: 24px 28px; margin-bottom: 52px;
}
.pol-toc-label {
    font-size: .7rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .1em; color: var(--pink); margin-bottom: 14px;
    font-family: 'Inter', sans-serif;
}
.pol-toc ol {
    margin: 0; padding-left: 18px;
    display: flex; flex-direction: column; gap: 8px;
}
.pol-toc a {
    color: rgba(255,255,255,.42); font-size: .88rem;
    font-family: 'Inter', sans-serif; text-decoration: none; transition: color .18s;
}
.pol-toc a:hover { color: #ff6ab4; }

/* ── Sections ── */
.pol-section { margin-bottom: 52px; scroll-margin-top: 90px; }
.pol-section-header {
    display: flex; align-items: center; gap: 14px;
    margin-bottom: 22px; padding-bottom: 14px;
    border-bottom: 1px solid rgba(232,62,140,.14);
}
.pol-section-num {
    width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
    background: linear-gradient(135deg, var(--pink), var(--pink-dark));
    color: #fff; font-size: 14px; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 4px 14px rgba(232,62,140,.35);
}
.pol-section h2 {
    font-family: 'Playfair Display', serif;
    font-size: 1.25rem; font-weight: 800; color: #fff; margin: 0;
}

.pol-para {
    color: rgba(255,255,255,.48); font-size: .9rem; line-height: 1.9;
    font-family: 'Inter', sans-serif; margin: 0 0 14px;
}
.pol-para:last-child { margin: 0; }

/* ── Cards Mission/Vision/Valeurs ── */
.pol-values {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-top: 28px;
}
.pol-value-card {
    background: rgba(255,255,255,.03); border: 1px solid rgba(255,255,255,.07);
    border-radius: 16px; padding: 22px 20px;
    border-top: 2px solid rgba(232,62,140,.3);
    transition: .25s;
}
.pol-value-card:hover {
    background: rgba(232,62,140,.05);
    border-color: rgba(232,62,140,.25);
    transform: translateY(-3px);
}
.pol-value-icon {
    width: 40px; height: 40px; border-radius: 10px; flex-shrink: 0;
    background: rgba(232,62,140,.12); color: var(--pink);
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; margin-bottom: 14px;
}
.pol-value-card h4 {
    font-size: 13.5px; font-weight: 700; color: rgba(255,255,255,.85);
    margin: 0 0 8px; font-family: 'Inter', sans-serif;
}
.pol-value-card p {
    font-size: 12.5px; color: rgba(255,255,255,.38); line-height: 1.65;
    margin: 0; font-family: 'Inter', sans-serif;
}

/* ── Highlight (expertise) ── */
.pol-highlight {
    background: rgba(255,255,255,.025); border: 1px solid rgba(255,255,255,.07);
    border-left: 3px solid var(--pink); border-radius: 0 14px 14px 0;
    padding: 24px 26px; margin-top: 4px;
}
.pol-highlight p {
    color: rgba(255,255,255,.45); font-size: .88rem; line-height: 1.85;
    font-family: 'Inter', sans-serif; margin: 0 0 12px;
}
.pol-highlight p:last-child { margin: 0; }
.pol-highlight strong { color: #ff6ab4; font-weight: 600; }

/* ── Rules ── */
.pol-rules {
    list-style: none; padding: 0; margin: 0;
    display: flex; flex-direction: column; gap: 10px;
}
.pol-rules li {
    display: flex; align-items: flex-start; gap: 12px;
    font-size: .875rem; color: rgba(255,255,255,.45);
    font-family: 'Inter', sans-serif; line-height: 1.65;
    padding: 14px 18px;
    background: rgba(255,255,255,.025);
    border: 1px solid rgba(255,255,255,.055);
    border-radius: 12px; transition: .2s;
}
.pol-rules li:hover {
    background: rgba(232,62,140,.05);
    border-color: rgba(232,62,140,.15);
}
.pol-rule-icon {
    width: 22px; height: 22px; border-radius: 50%; flex-shrink: 0;
    background: rgba(232,62,140,.15); color: var(--pink);
    font-size: 10px; display: flex; align-items: center; justify-content: center;
    margin-top: 2px;
}
.pol-rules strong { color: rgba(255,255,255,.75); font-weight: 600; }

/* ── CTA ── */
.pol-cta {
    text-align: center;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    border: 1px solid rgba(232,62,140,.18);
    border-radius: 20px; padding: 52px 40px; margin-top: 16px;
    position: relative; overflow: hidden;
}
.pol-cta::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse 60% 80% at 50% 100%, rgba(232,62,140,.1), transparent);
    pointer-events: none;
}
.pol-cta h3 {
    font-family: 'Playfair Display', serif;
    font-size: 1.6rem; font-weight: 900; color: #fff;
    margin: 0 0 10px; position: relative;
}
.pol-cta p {
    font-size: .9rem; color: rgba(255,255,255,.45);
    margin: 0 0 26px; font-family: 'Inter', sans-serif; position: relative;
}
.pol-cta-btn {
    display: inline-flex; align-items: center; gap: 9px;
    background: var(--pink); color: #fff; padding: 13px 32px;
    border-radius: 12px; font-size: .88rem; font-weight: 700;
    text-decoration: none; transition: .2s; position: relative;
    box-shadow: 0 6px 24px rgba(232,62,140,.45);
    font-family: 'Inter', sans-serif;
}
.pol-cta-btn:hover { background: var(--pink-dark); transform: translateY(-2px); color: #fff; }

/* ── Responsive ── */
@media (max-width: 767px) {
    .pol-hero { padding: 52px 20px 40px; }
    .pol-values { grid-template-columns: 1fr; }
    .pol-cta { padding: 36px 24px; }
}
@media (max-width: 480px) {
    .pol-section h2 { font-size: 1.1rem; }
}
</style>
@endpush

@section('content')

{{-- Hero ── ──────────────────────────────────────────── --}}
<div class="pol-hero">
    <div class="container">
        <div class="pol-crumb">
            <a href="{{ route('home') }}">{{ __('messages.nav_link_home') }}</a>
            <span>›</span>
            {{ __('messages.pol_breadcrumb') }}
        </div>
        <div class="pol-eyebrow" style="margin-top:18px;">
            <i class="fa-solid fa-shield-halved"></i>
            {{ __('messages.pol_hero_label') }}
        </div>
        <h1>
            <span>{{ __('messages.pol_hero_title_1') }}</span>
            {{ __('messages.pol_hero_title_2') }}
        </h1>
        <p class="pol-hero-sub">{{ __('messages.pol_hero_sub') }}</p>
    </div>
</div>

{{-- Body ── ──────────────────────────────────────────── --}}
<div class="pol-body-wrap">
<div class="container pol-container">

    {{-- Table des matières --}}
    <div class="pol-toc">
        <div class="pol-toc-label"><i class="fa-solid fa-list" style="margin-right:6px;"></i>{{ __('messages.pol_breadcrumb') }}</div>
        <ol>
            <li><a href="#section-1">{{ __('messages.pol_s1_title') }}</a></li>
            <li><a href="#section-2">{{ __('messages.pol_s2_title') }}</a></li>
            <li><a href="#section-3">{{ __('messages.pol_s3_title') }}</a></li>
            <li><a href="#section-4">{{ __('messages.pol_s4_title') }}</a></li>
        </ol>
    </div>

    {{-- Section 1 — Welcome ── --}}
    <div class="pol-section" id="section-1">
        <div class="pol-section-header">
            <div class="pol-section-num">{{ __('messages.pol_s1_num') }}</div>
            <h2>{{ __('messages.pol_s1_title') }}</h2>
        </div>
        <p class="pol-para">{{ __('messages.pol_s1_p1') }}</p>
        <p class="pol-para">{{ __('messages.pol_s1_p2') }}</p>
    </div>

    {{-- Section 2 — Mission Vision Valeurs ── --}}
    <div class="pol-section" id="section-2">
        <div class="pol-section-header">
            <div class="pol-section-num">{{ __('messages.pol_s2_num') }}</div>
            <h2>{{ __('messages.pol_s2_title') }}</h2>
        </div>
        <p class="pol-para">{{ __('messages.pol_s2_intro') }}</p>
        <div class="pol-values">
            <div class="pol-value-card">
                <div class="pol-value-icon"><i class="fa-solid fa-bullseye"></i></div>
                <h4>{{ __('messages.pol_mission_title') }}</h4>
                <p>{{ __('messages.pol_mission_text') }}</p>
            </div>
            <div class="pol-value-card">
                <div class="pol-value-icon"><i class="fa-solid fa-eye"></i></div>
                <h4>{{ __('messages.pol_vision_title') }}</h4>
                <p>{{ __('messages.pol_vision_text') }}</p>
            </div>
            <div class="pol-value-card">
                <div class="pol-value-icon"><i class="fa-solid fa-heart"></i></div>
                <h4>{{ __('messages.pol_values_title') }}</h4>
                <p>{{ __('messages.pol_values_text') }}</p>
            </div>
        </div>
    </div>

    {{-- Section 3 — Expertise ── --}}
    <div class="pol-section" id="section-3">
        <div class="pol-section-header">
            <div class="pol-section-num">{{ __('messages.pol_s3_num') }}</div>
            <h2>{{ __('messages.pol_s3_title') }}</h2>
        </div>
        <div class="pol-highlight">
            <p>{!! __('messages.pol_s3_p1') !!}</p>
            <p>{!! __('messages.pol_s3_p2') !!}</p>
            <p>{!! __('messages.pol_s3_p3') !!}</p>
        </div>
    </div>

    {{-- Section 4 — Règles du salon ── --}}
    <div class="pol-section" id="section-4">
        <div class="pol-section-header">
            <div class="pol-section-num">{{ __('messages.pol_s4_num') }}</div>
            <h2>{{ __('messages.pol_s4_title') }}</h2>
        </div>
        <ul class="pol-rules">
            <li>
                <div class="pol-rule-icon"><i class="fa-solid fa-check"></i></div>
                <span><strong>{{ __('messages.pol_rule1_title') }} :</strong> {{ __('messages.pol_rule1_text') }}</span>
            </li>
            <li>
                <div class="pol-rule-icon"><i class="fa-solid fa-check"></i></div>
                <span><strong>{{ __('messages.pol_rule2_title') }} :</strong> {{ __('messages.pol_rule2_text') }}</span>
            </li>
            <li>
                <div class="pol-rule-icon"><i class="fa-solid fa-clock"></i></div>
                <span><strong>{{ __('messages.pol_rule3_title') }} :</strong> {{ __('messages.pol_rule3_text') }}</span>
            </li>
            <li>
                <div class="pol-rule-icon"><i class="fa-solid fa-scissors"></i></div>
                <span><strong>{{ __('messages.pol_rule4_title') }} :</strong> {{ __('messages.pol_rule4_text') }}</span>
            </li>
            <li>
                <div class="pol-rule-icon"><i class="fa-solid fa-child"></i></div>
                <span><strong>{{ __('messages.pol_rule5_title') }} :</strong> {{ __('messages.pol_rule5_text') }}</span>
            </li>
            <li>
                <div class="pol-rule-icon"><i class="fa-regular fa-credit-card"></i></div>
                <span><strong>{{ __('messages.pol_rule6_title') }} :</strong> {{ __('messages.pol_rule6_text') }}</span>
            </li>
            <li>
                <div class="pol-rule-icon"><i class="fa-solid fa-star"></i></div>
                <span><strong>{{ __('messages.pol_rule7_title') }} :</strong> {{ __('messages.pol_rule7_text') }}</span>
            </li>
        </ul>
    </div>

    {{-- CTA ── --}}
    <div class="pol-cta">
        <h3>{{ __('messages.pol_cta_title') }}</h3>
        <p>{{ __('messages.pol_cta_desc') }}</p>
        <a href="{{ route('booking.start') }}" class="pol-cta-btn">
            <i class="fa-regular fa-calendar-check"></i>
            {{ __('messages.pol_cta_btn') }}
        </a>
    </div>

</div>
</div>

@endsection
