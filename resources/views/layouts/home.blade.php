<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Marol Hair Braiding')</title>

    @include('partials.seo-meta')

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')

    <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
        --pink:      #e83e8c;
        --pink-dark: #c91a78;
        --dark:      #1a1a2e;
        --dark2:     #16213e;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: #fff;
        color: #333;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    /* ═══════════════════════════════════════════════
       NAVBAR  — pixel-perfect vs image
    ═══════════════════════════════════════════════ */
    .nav-bar {
        background: #1a1a2e;
        border-bottom: 1px solid rgba(255,255,255,.06);
        box-shadow: none;
        position: sticky;
        top: 0;
        z-index: 900;
        height: 68px;
        display: flex;
        align-items: center;
        padding: 0 40px;
        gap: 0;
    }

    /* ── LOGO ── */
    .nav-logo {
        display: flex;
        align-items: center;
        gap: 9px;
        text-decoration: none;
        flex-shrink: 0;
        margin-right: 36px;
    }
    /* Logo image badge */
    .nav-logo-flame {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        overflow: hidden;
        flex-shrink: 0;
        border: 2.5px solid rgba(233,30,140,.55);
        box-shadow: 0 0 0 3px rgba(233,30,140,.15), 0 4px 14px rgba(0,0,0,.4);
        transition: transform .3s, box-shadow .3s;
    }
    .nav-logo-flame:hover {
        transform: scale(1.05);
        box-shadow: 0 0 0 4px rgba(233,30,140,.3), 0 6px 18px rgba(0,0,0,.5);
    }
    .nav-logo-flame img {
        width: 100%; height: 100%;
        object-fit: cover; display: block;
    }
    .nav-logo-words { line-height: 1.0; }
    .nav-logo-marol {
        display: block;
        font-family: 'Playfair Display', serif;
        font-size: 17px;
        font-weight: 900;
        color: #ffffff;
        letter-spacing: .04em;
        text-transform: uppercase;
        line-height: 1.15;
    }
    .nav-logo-sub {
        display: block;
        font-size: 8px;
        font-weight: 700;
        color: rgba(255,255,255,.45);
        letter-spacing: .18em;
        text-transform: uppercase;
        margin-top: 1px;
        line-height: 1.4;
    }
    .nav-logo-salon {
        display: block;
        font-size: 7px;
        font-weight: 600;
        color: var(--pink);
        letter-spacing: .28em;
        text-transform: uppercase;
        margin-top: 1px;
    }

    /* ── NAV LINKS ── */
    .nav-links {
        display: flex;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
        flex: 1;
        gap: 0;
    }
    .nav-links li a {
        display: block;
        padding: 0 11px;
        height: 68px;
        line-height: 68px;
        font-size: 13px;
        font-weight: 500;
        color: rgba(255,255,255,.72);
        text-decoration: none;
        position: relative;
        transition: color .18s;
        white-space: nowrap;
    }
    .nav-links li a:hover { color: var(--pink); }
    .nav-links li a.active {
        color: var(--pink);
        font-weight: 600;
    }
    .nav-links li a.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 15px;
        right: 15px;
        height: 2.5px;
        background: var(--pink);
        border-radius: 2px 2px 0 0;
    }

    /* ── RIGHT SIDE ── */
    .nav-right {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-left: auto;
        flex-shrink: 0;
    }

    /* Circle icon buttons (heart & share) */
    .nav-circle-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 1.5px solid rgba(255,255,255,.18);
        background: rgba(255,255,255,.06);
        display: flex;
        align-items: center;
        justify-content: center;
        color: rgba(255,255,255,.65);
        font-size: 14px;
        cursor: pointer;
        text-decoration: none;
        transition: .2s;
        flex-shrink: 0;
    }
    .nav-circle-btn:hover {
        border-color: var(--pink);
        color: var(--pink);
        background: rgba(232,62,140,.1);
    }

    /* Language pill */
    .nav-lang-wrap {
        position: relative;
        margin-left: 2px;
    }
    .nav-lang-pill {
        display: flex;
        align-items: center;
        gap: 5px;
        border: 1.5px solid rgba(255,255,255,.18);
        border-radius: 20px;
        padding: 5px 11px 5px 8px;
        font-size: 13px;
        font-weight: 600;
        color: rgba(255,255,255,.75);
        cursor: pointer;
        background: rgba(255,255,255,.06);
        transition: border-color .2s;
        user-select: none;
        white-space: nowrap;
    }
    .nav-lang-pill:hover { border-color: rgba(255,255,255,.4); }
    .nav-lang-flag {
        font-size: 16px;
        line-height: 1;
    }
    .nav-lang-code {
        font-size: 12.5px;
        font-weight: 700;
        color: rgba(255,255,255,.75);
        letter-spacing: .02em;
    }
    .nav-lang-chevron {
        font-size: 9px;
        color: rgba(255,255,255,.4);
        margin-left: 1px;
        transition: transform .2s;
    }
    .nav-lang-wrap.open .nav-lang-chevron { transform: rotate(180deg); }
    /* Dropdown */
    .nav-lang-drop {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 12px;
        min-width: 140px;
        box-shadow: 0 8px 28px rgba(0,0,0,.11);
        z-index: 9999;
        overflow: hidden;
        padding: 4px 0;
    }
    .nav-lang-wrap.open .nav-lang-drop { display: block; }
    .nav-lang-opt {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 10px 16px;
        font-size: 13.5px;
        font-weight: 500;
        color: #444;
        text-decoration: none;
        transition: background .15s;
    }
    .nav-lang-opt:hover { background: rgba(232,62,140,.07); color: var(--pink); }
    .nav-lang-opt.active { color: var(--pink); font-weight: 700; }
    .nav-lang-opt-flag { font-size: 18px; }

    /* Book Now button */
    .nav-book-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--pink);
        color: #ffffff !important;
        padding: 9px 20px;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 700;
        text-decoration: none;
        transition: .22s;
        white-space: nowrap;
        box-shadow: 0 4px 16px rgba(232,62,140,.35);
        margin-left: 6px;
        flex-shrink: 0;
    }
    .nav-book-btn:hover {
        background: var(--pink-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 22px rgba(232,62,140,.45);
        color: #fff !important;
    }
    .nav-book-btn i { font-size: 13px; }

    /* ── HAMBURGER (mobile) ── */
    .nav-hamburger {
        display: none;
        width: 38px; height: 38px;
        border: 1.5px solid rgba(255,255,255,.2);
        border-radius: 8px;
        background: rgba(255,255,255,.07);
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 16px;
        color: rgba(255,255,255,.85);
        margin-left: 8px;
        transition: .2s;
        flex-shrink: 0;
    }
    .nav-hamburger:hover { background: rgba(232,62,140,.15); border-color: var(--pink); color: var(--pink); }

    /* ═══════════════════════════════════════════════
       MOBILE DRAWER — dark theme
    ═══════════════════════════════════════════════ */
    .drawer-bg {
        display: none;
        position: fixed; inset: 0;
        background: rgba(10,8,26,.7);
        z-index: 980;
        backdrop-filter: blur(4px);
    }
    .drawer-bg.open { display: block; }

    .drawer-panel {
        position: fixed;
        top: 0; right: -320px;
        width: 300px;
        height: 100dvh;
        background: linear-gradient(160deg, #1a1a2e 0%, #16213e 60%, #0f0e2a 100%);
        z-index: 990;
        transition: right .32s cubic-bezier(.4,0,.2,1);
        display: flex;
        flex-direction: column;
        box-shadow: -8px 0 48px rgba(0,0,0,.45);
        overflow-y: auto;
        overflow-x: hidden;
    }
    .drawer-panel.open { right: 0; }

    /* decorative pink glow */
    .drawer-panel::before {
        content: '';
        position: absolute;
        top: -60px; right: -60px;
        width: 240px; height: 240px;
        background: radial-gradient(circle, rgba(232,62,140,.18) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }
    .drawer-panel::after {
        content: '';
        position: absolute;
        bottom: 40px; left: -40px;
        width: 180px; height: 180px;
        background: radial-gradient(circle, rgba(100,60,200,.1) 0%, transparent 70%);
        pointer-events: none;
        z-index: 0;
    }

    /* header */
    .drawer-top {
        position: relative; z-index: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 18px 15px;
        border-bottom: 1px solid rgba(255,255,255,.07);
        background: rgba(255,255,255,.03);
        backdrop-filter: blur(8px);
        flex-shrink: 0;
    }
    .drawer-top::after {
        content: '';
        position: absolute;
        bottom: 0; left: 18px; right: 18px;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(232,62,140,.4), transparent);
    }
    .drawer-x {
        width: 34px; height: 34px;
        border: 1.5px solid rgba(255,255,255,.15);
        background: rgba(255,255,255,.06);
        border-radius: 8px; cursor: pointer;
        font-size: 14px; color: rgba(255,255,255,.6);
        display: flex; align-items: center; justify-content: center;
        transition: .2s;
        flex-shrink: 0;
    }
    .drawer-x:hover {
        background: rgba(232,62,140,.2);
        border-color: var(--pink);
        color: var(--pink);
    }

    /* nav links */
    .drawer-nav {
        padding: 14px 14px 8px;
        flex: 1;
        position: relative; z-index: 1;
    }
    .drawer-nav a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
        font-size: 14px;
        font-weight: 500;
        color: rgba(255,255,255,.65);
        text-decoration: none;
        border-radius: 10px;
        margin-bottom: 2px;
        transition: background .18s, color .18s;
        border-left: 3px solid transparent;
    }
    .drawer-nav a i,
    .drawer-nav a svg {
        width: 18px;
        text-align: center;
        color: rgba(255,255,255,.3);
        font-size: 14px;
        flex-shrink: 0;
        transition: color .18s;
    }
    .drawer-nav a:hover {
        background: rgba(232,62,140,.1);
        color: rgba(255,255,255,.95);
        border-left-color: rgba(232,62,140,.5);
    }
    .drawer-nav a:hover i,
    .drawer-nav a:hover svg { color: var(--pink); }
    .drawer-nav a.active {
        background: rgba(232,62,140,.14);
        color: #fff;
        font-weight: 600;
        border-left-color: var(--pink);
    }
    .drawer-nav a.active i,
    .drawer-nav a.active svg { color: var(--pink); }

    /* separator */
    .drawer-sep {
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,.08), transparent);
        margin: 6px 14px;
        position: relative; z-index: 1;
    }

    /* language strip in drawer */
    .drawer-lang {
        padding: 12px 14px 10px;
        position: relative; z-index: 1;
    }
    .drawer-lang-label {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .16em;
        text-transform: uppercase;
        color: rgba(255,255,255,.28);
        padding: 0 4px;
        margin-bottom: 10px;
    }
    .drawer-lang-label::before {
        content: '';
        display: inline-block;
        width: 18px; height: 1px;
        background: rgba(255,255,255,.15);
    }
    .drawer-lang-label::after {
        content: '';
        display: inline-block;
        flex: 1; height: 1px;
        background: rgba(255,255,255,.07);
    }
    .drawer-lang-opts {
        display: flex;
        gap: 8px;
    }
    .drawer-lang-opt {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        padding: 11px 8px;
        border-radius: 12px;
        border: 1.5px solid rgba(255,255,255,.1);
        background: rgba(255,255,255,.04);
        text-decoration: none;
        color: rgba(255,255,255,.55);
        transition: .2s;
        cursor: pointer;
    }
    .drawer-lang-opt .dl-flag { font-size: 22px; line-height: 1; }
    .drawer-lang-opt .dl-code {
        font-size: 10.5px; font-weight: 700;
        letter-spacing: .06em;
        color: rgba(255,255,255,.45);
        transition: color .2s;
    }
    .drawer-lang-opt:hover {
        border-color: rgba(232,62,140,.5);
        background: rgba(232,62,140,.1);
        color: #fff;
    }
    .drawer-lang-opt:hover .dl-code { color: var(--pink); }
    .drawer-lang-opt.active {
        border-color: var(--pink);
        background: rgba(232,62,140,.15);
        box-shadow: 0 0 0 1px rgba(232,62,140,.2), 0 4px 14px rgba(232,62,140,.15);
    }
    .drawer-lang-opt.active .dl-code { color: var(--pink); }

    /* ── Auth buttons in drawer ── */
    .drawer-auth {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .drawer-auth-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 13px 18px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        background: var(--pink);
        color: #fff !important;
        border: 1.5px solid var(--pink);
        transition: .22s;
        letter-spacing: .01em;
        box-shadow: 0 4px 16px rgba(232,62,140,.3);
    }
    .drawer-auth-btn:hover {
        background: var(--pink-dark);
        border-color: var(--pink-dark);
        color: #fff !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 22px rgba(232,62,140,.45);
    }
    .drawer-auth-btn--ghost {
        background: rgba(255,255,255,.06);
        color: rgba(255,255,255,.82) !important;
        border: 1.5px solid rgba(255,255,255,.18);
        box-shadow: none;
    }
    .drawer-auth-btn--ghost:hover {
        background: rgba(255,255,255,.1);
        border-color: rgba(255,255,255,.35);
        color: #fff !important;
        transform: translateY(-1px);
        box-shadow: none;
    }

    /* CTA button */
    .drawer-cta {
        margin: 10px 16px 24px;
        position: relative; z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        background: linear-gradient(135deg, var(--pink) 0%, #c91a78 100%);
        color: #fff !important;
        padding: 14px;
        border-radius: 12px;
        font-size: 14.5px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 6px 24px rgba(232,62,140,.4), 0 0 0 1px rgba(232,62,140,.2);
        transition: .22s;
        letter-spacing: .01em;
    }
    .drawer-cta:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(232,62,140,.5), 0 0 0 1px rgba(232,62,140,.3);
        color: #fff !important;
    }
    .drawer-cta i { font-size: 15px; }

    /* ═══════════════════════════════════════════════
       FOOTER
    ═══════════════════════════════════════════════ */
    .hp-footer {
        background: var(--dark);
        color: rgba(255,255,255,.45);
        margin-top: auto;
    }
    .hp-footer-main {
        display: grid;
        grid-template-columns: 1.8fr 1fr 1fr 1.6fr;
        gap: 48px;
        padding: 64px 52px 52px;
    }
    .hp-footer-logo-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }
    .hp-footer-flame {
        width: 42px; height: 42px; flex-shrink: 0;
        border-radius: 50%; overflow: hidden;
        border: 2px solid rgba(233,30,140,.4);
        box-shadow: 0 0 0 3px rgba(233,30,140,.1);
    }
    .hp-footer-flame img { width: 100%; height: 100%; object-fit: cover; display: block; }
    .hp-footer-brand { line-height: 1.1; }
    .hp-footer-brand-name {
        display: block;
        font-family: 'Playfair Display', serif;
        font-size: 17px;
        font-weight: 900;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .hp-footer-brand-sub {
        display: block;
        font-size: 7.5px;
        color: rgba(255,255,255,.25);
        letter-spacing: .2em;
        text-transform: uppercase;
        margin-top: 2px;
    }
    .hp-footer-tagline {
        font-size: 12.5px;
        color: rgba(255,255,255,.3);
        line-height: 1.7;
        max-width: 210px;
    }
    .hp-footer-col-title {
        font-size: 13.5px;
        font-weight: 700;
        color: rgba(255,255,255,.82);
        margin-bottom: 18px;
        letter-spacing: .01em;
    }
    .hp-footer-links {
        list-style: none; padding: 0; margin: 0;
        display: flex; flex-direction: column; gap: 10px;
    }
    .hp-footer-links a {
        color: rgba(255,255,255,.38);
        font-size: 13px;
        text-decoration: none;
        transition: color .18s;
    }
    .hp-footer-links a:hover { color: var(--pink); }
    .hp-footer-socials {
        display: flex; gap: 9px; margin-bottom: 24px;
    }
    .hp-footer-soc {
        width: 36px; height: 36px;
        border-radius: 50%;
        border: 1.5px solid rgba(255,255,255,.11);
        background: rgba(255,255,255,.04);
        display: flex; align-items: center; justify-content: center;
        color: rgba(255,255,255,.38);
        font-size: 14px;
        text-decoration: none;
        transition: .2s;
    }
    .hp-footer-soc:hover {
        background: var(--pink); border-color: var(--pink);
        color: #fff; transform: translateY(-2px);
    }
    .hp-footer-sub-label {
        font-size: 12px;
        color: rgba(255,255,255,.32);
        margin-bottom: 10px;
    }
    .hp-footer-sub-form {
        display: flex;
        border: 1.5px solid rgba(255,255,255,.1);
        border-radius: 8px;
        overflow: hidden;
        background: rgba(255,255,255,.04);
    }
    .hp-footer-sub-form input {
        flex: 1; background: transparent; border: none; outline: none;
        padding: 10px 13px; color: #fff; font-size: 12.5px; font-family: 'Inter', sans-serif;
    }
    .hp-footer-sub-form input::placeholder { color: rgba(255,255,255,.2); }
    .hp-footer-sub-btn {
        background: var(--pink); color: #fff; border: none;
        padding: 10px 16px; font-size: 13px; font-weight: 700; cursor: pointer;
        transition: background .2s; font-family: 'Inter', sans-serif; white-space: nowrap;
    }
    .hp-footer-sub-btn:hover { background: var(--pink-dark); }
    .hp-footer-bottom {
        border-top: 1px solid rgba(255,255,255,.06);
        padding: 16px 52px;
        text-align: center;
        font-size: 12px;
        color: rgba(255,255,255,.2);
    }

    /* ═══════════════════════════════════════════════
       RESPONSIVE NAV
    ═══════════════════════════════════════════════ */
    @media (max-width: 991px) {
        .nav-bar { padding: 0 20px; height: 62px; }
        .nav-links { display: none; }
        .nav-hamburger { display: flex; }
        .nav-logo { margin-right: 0; }
    }
    @media (max-width: 767px) {
        .nav-bar { padding: 0 16px; height: 58px; }
        .nav-lang-wrap { display: none; }
        .nav-circle-btn { display: none; }
        .nav-book-btn { padding: 8px 14px; font-size: 12.5px; gap: 5px; }
        .nav-book-btn i { display: none; }
    }
    @media (max-width: 400px) {
        .nav-bar { padding: 0 12px; }
        .nav-logo-sub, .nav-logo-salon { display: none; }
        .nav-book-btn { display: none; }
    }
    /* ── Override : remplace l'ancienne navbar par main-navbar ── */
    body { padding-top: 78px; }
    .nav-bar, .drawer-bg, .drawer-panel { display: none !important; }
    </style>
</head>
<body>

@include('partials.main-navbar')

{{-- ══ MOBILE DRAWER ══ (conservé mais masqué) --}}
<div class="drawer-bg" id="drawerBg" onclick="drawerClose()"></div>
<div class="drawer-panel" id="drawerPanel">

    {{-- ── Header ── --}}
    <div class="drawer-top">
        <a href="{{ route('home') }}" class="nav-logo" style="margin:0;" onclick="drawerClose()">
            <div class="nav-logo-flame">
                <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair Braiding">
            </div>
            <div class="nav-logo-words">
                <span class="nav-logo-marol">Marol</span>
                <span class="nav-logo-sub">Hair Braiding</span>
                <span class="nav-logo-salon">Salon</span>
            </div>
        </a>
        <button class="drawer-x" onclick="drawerClose()">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    {{-- ── Nav links ── --}}
    <div class="drawer-nav">
        <a href="{{ route('home') }}"           class="{{ request()->routeIs('home')       ? 'active' : '' }}" onclick="drawerClose()">
            <i class="fa-solid fa-house"></i> {{ __('messages.nav_link_home') }}
        </a>
        <a href="{{ route('booking.start') }}"  class="{{ request()->routeIs('booking.*')  ? 'active' : '' }}" onclick="drawerClose()">
            <i class="fa-regular fa-calendar-check"></i> {{ __('messages.nav_link_appointment') }}
        </a>
        <a href="{{ route('stylists.index') }}" class="{{ request()->routeIs('stylists.*') ? 'active' : '' }}" onclick="drawerClose()">
            <i class="fa-solid fa-scissors"></i> {{ __('messages.nav_link_stylists') }}
        </a>
        <a href="{{ route('gallery.index') }}"  class="{{ request()->routeIs('gallery.*')  ? 'active' : '' }}" onclick="drawerClose()">
            <i class="fa-solid fa-images"></i> {{ __('messages.nav_link_gallery') }}
        </a>
        <a href="{{ route('about') }}"          class="{{ request()->routeIs('about')      ? 'active' : '' }}" onclick="drawerClose()">
            <i class="fa-solid fa-circle-info"></i> {{ __('messages.nav_link_about') }}
        </a>
        <a href="{{ route('contact') }}"        class="{{ request()->routeIs('contact')    ? 'active' : '' }}" onclick="drawerClose()">
            <i class="fa-solid fa-envelope"></i> {{ __('messages.nav_link_contact') }}
        </a>
    </div>

    {{-- ── Separator ── --}}
    <div class="drawer-sep"></div>

    {{-- ── Language selector ── --}}
    @php $loc = app()->getLocale(); @endphp
    <div class="drawer-lang">
        <div class="drawer-lang-label">{{ __('messages.nav_lang_label') }}</div>
        <div class="drawer-lang-opts">
            <a href="{{ route('locale.switch','en') }}" class="drawer-lang-opt {{ $loc==='en'?'active':'' }}">
                <span class="dl-flag">🇺🇸</span>
                <span class="dl-code">EN</span>
            </a>
            <a href="{{ route('locale.switch','fr') }}" class="drawer-lang-opt {{ $loc==='fr'?'active':'' }}">
                <span class="dl-flag">🇫🇷</span>
                <span class="dl-code">FR</span>
            </a>
            <a href="{{ route('locale.switch','es') }}" class="drawer-lang-opt {{ $loc==='es'?'active':'' }}">
                <span class="dl-flag">🇪🇸</span>
                <span class="dl-code">ES</span>
            </a>
        </div>
    </div>

    {{-- ── Auth quick links ── --}}
    @guest
    <div class="drawer-sep"></div>
    <div class="drawer-auth" style="padding:10px 16px 8px;position:relative;z-index:1;">
        <a href="{{ route('login') }}" class="drawer-auth-btn" onclick="drawerClose()">
            <i class="fa-solid fa-right-to-bracket"></i>
            <span>{{ __('messages.nav_login') }}</span>
        </a>
        <a href="{{ route('register') }}" class="drawer-auth-btn drawer-auth-btn--ghost" onclick="drawerClose()">
            <i class="fa-solid fa-user-plus"></i>
            <span>{{ __('messages.nav_register') }}</span>
        </a>
    </div>
    @endguest

    {{-- ── CTA ── --}}
    <a href="{{ route('booking.start') }}" class="drawer-cta" onclick="drawerClose()">
        <i class="fa-regular fa-calendar-check"></i> {{ __('messages.nav_btn_book') }}
    </a>

</div>

{{-- ══ NAVBAR ══ --}}
<nav class="nav-bar">

    {{-- LOGO --}}
    <a href="{{ route('home') }}" class="nav-logo">
        <div class="nav-logo-flame">
            <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair Braiding">
        </div>
        <div class="nav-logo-words">
            <span class="nav-logo-marol">Marol</span>
            <span class="nav-logo-sub">Hair Braiding</span>
            <span class="nav-logo-salon">Salon</span>
        </div>
    </a>

    {{-- LINKS --}}
    <ul class="nav-links">
        <li><a href="{{ route('home') }}"          class="{{ request()->routeIs('home')       ? 'active' : '' }}">{{ __('messages.nav_link_home') }}</a></li>
        <li><a href="{{ route('booking.start') }}" class="{{ request()->routeIs('booking.*')  ? 'active' : '' }}">{{ __('messages.nav_link_appointment') }}</a></li>
        <li><a href="{{ route('stylists.index') }}" class="{{ request()->routeIs('stylists.*') ? 'active' : '' }}">{{ __('messages.nav_link_stylists') }}</a></li>
        <li><a href="{{ route('gallery.index') }}" class="{{ request()->routeIs('gallery.*')  ? 'active' : '' }}">{{ __('messages.nav_link_gallery') }}</a></li>
        <li><a href="{{ route('about') }}"         class="{{ request()->routeIs('about')      ? 'active' : '' }}">{{ __('messages.nav_link_about') }}</a></li>
        <li><a href="{{ route('contact') }}"       class="{{ request()->routeIs('contact')    ? 'active' : '' }}">{{ __('messages.nav_link_contact') }}</a></li>
    </ul>

    {{-- RIGHT --}}
    <div class="nav-right">

        {{-- Heart --}}
        <a href="{{ route('login') }}" class="nav-circle-btn" title="Favoris">
            <i class="fa-regular fa-heart"></i>
        </a>

        {{-- Share --}}
        <button class="nav-circle-btn" title="Partager" onclick="navigator.share ? navigator.share({title:'Marol Hair Braiding',url:window.location.href}) : null" style="border:1.5px solid #ddd;cursor:pointer;">
            <i class="fa-solid fa-share-nodes"></i>
        </button>

        {{-- Language selector --}}
        @php $loc = app()->getLocale(); @endphp
        <div class="nav-lang-wrap" id="navLangWrap">
            <div class="nav-lang-pill" onclick="navLangToggle()">
                <span class="nav-lang-flag">
                    @if($loc==='fr') 🇫🇷
                    @elseif($loc==='en') 🇺🇸
                    @else 🇪🇸
                    @endif
                </span>
                <span class="nav-lang-code">{{ strtoupper($loc) }}</span>
                <i class="fa-solid fa-chevron-down nav-lang-chevron"></i>
            </div>
            <div class="nav-lang-drop">
                <a href="{{ route('locale.switch','en') }}" class="nav-lang-opt {{ $loc==='en'?'active':'' }}">
                    <span class="nav-lang-opt-flag">🇺🇸</span> {{ __('messages.nav_lang_en') }}
                </a>
                <a href="{{ route('locale.switch','fr') }}" class="nav-lang-opt {{ $loc==='fr'?'active':'' }}">
                    <span class="nav-lang-opt-flag">🇫🇷</span> {{ __('messages.nav_lang_fr') }}
                </a>
                <a href="{{ route('locale.switch','es') }}" class="nav-lang-opt {{ $loc==='es'?'active':'' }}">
                    <span class="nav-lang-opt-flag">🇪🇸</span> {{ __('messages.nav_lang_es') }}
                </a>
            </div>
        </div>

        {{-- Book Now --}}
        <a href="{{ route('booking.start') }}" class="nav-book-btn">
            <i class="fa-regular fa-calendar-check"></i> {{ __('messages.nav_btn_book') }}
        </a>

        {{-- Hamburger --}}
        <button class="nav-hamburger" onclick="drawerOpen()">
            <i class="fa-solid fa-bars"></i>
        </button>

    </div>
</nav>

{{-- ══ CONTENT ══ --}}
@yield('content')

{{-- ══ FOOTER ══ --}}
@include('partials.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function drawerOpen()  { document.getElementById('drawerPanel').classList.add('open'); document.getElementById('drawerBg').classList.add('open'); document.body.style.overflow='hidden'; }
function drawerClose() { document.getElementById('drawerPanel').classList.remove('open'); document.getElementById('drawerBg').classList.remove('open'); document.body.style.overflow=''; }
function navLangToggle() { document.getElementById('navLangWrap').classList.toggle('open'); }
document.addEventListener('click', function(e) {
    var w = document.getElementById('navLangWrap');
    if (w && !w.contains(e.target)) w.classList.remove('open');
});
</script>
@stack('scripts')
@include('partials.toast')
</body>
</html>
