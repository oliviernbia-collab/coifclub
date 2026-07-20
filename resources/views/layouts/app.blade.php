<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('messages.site_title'))</title>

    @include('partials.seo-meta')

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,600&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')

    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }


        :root {
            --pink:       #e83e8c;
            --pink-dark:  #c91a78;
            --dark:       #1a1a2e;
            --cream:      #faf6f1;
            --champagne:  #f0e6d6;
            --blush:      #f5ddd8;
            --rose:       #c8836a;
            --rose-deep:  #a5614b;
            --gold:       #c9a96e;
            --gold-light: #e8d5af;
            --wine:       #6b2d3e;
            --wine-dark:  #4a1d2a;
            --warm-grey:  #8a7e75;
            --text-dark:  #2c1a12;
            --text-mid:   #5c4033;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #0e0a1c;
            color: rgba(255,255,255,.85);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ═══ NAVBAR (same as home layout) ══════════════ */
        .nav-bar {
            background: #1a1a2e;
            border-bottom: 1px solid rgba(255,255,255,.06);
            position: sticky;
            top: 0;
            z-index: 900;
            height: 68px;
            display: flex;
            align-items: center;
            padding: 0 40px;
        }

        /* Logo */
        .nav-logo {
            display: flex; align-items: center; gap: 9px;
            text-decoration: none; flex-shrink: 0; margin-right: 36px;
        }
        .nav-logo-flame {
            width: 44px; height: 44px; border-radius: 50%; overflow: hidden; flex-shrink: 0;
            border: 2.5px solid rgba(233,30,140,.55);
            box-shadow: 0 0 0 3px rgba(233,30,140,.15), 0 4px 14px rgba(0,0,0,.4);
            transition: transform .3s, box-shadow .3s;
        }
        .nav-logo-flame:hover { transform: scale(1.05); box-shadow: 0 0 0 4px rgba(233,30,140,.3), 0 6px 18px rgba(0,0,0,.5); }
        .nav-logo-flame img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .nav-logo-words { line-height: 1.0; }
        .nav-logo-marol { display: block; font-family: 'Playfair Display', serif; font-size: 17px; font-weight: 900; color: #fff; letter-spacing: .04em; text-transform: uppercase; line-height: 1.15; }
        .nav-logo-sub   { display: block; font-size: 8px; font-weight: 700; color: rgba(255,255,255,.45); letter-spacing: .18em; text-transform: uppercase; margin-top: 1px; }
        .nav-logo-salon { display: block; font-size: 7px; font-weight: 600; color: var(--pink); letter-spacing: .28em; text-transform: uppercase; margin-top: 1px; }

        /* Nav links */
        .nav-links {
            display: flex; align-items: center; list-style: none;
            margin: 0; padding: 0; flex: 1;
        }
        .nav-links li a {
            display: block; padding: 0 11px; height: 68px; line-height: 68px;
            font-size: 13px; font-weight: 500; color: rgba(255,255,255,.72);
            text-decoration: none; position: relative; transition: color .18s; white-space: nowrap;
        }
        .nav-links li a:hover { color: var(--pink); }
        .nav-links li a.active { color: var(--pink); font-weight: 600; }
        .nav-links li a.active::after {
            content: ''; position: absolute; bottom: 0; left: 15px; right: 15px;
            height: 2.5px; background: var(--pink); border-radius: 2px 2px 0 0;
        }

        /* Right side */
        .nav-right {
            display: flex; align-items: center; gap: 8px;
            margin-left: auto; flex-shrink: 0;
        }

        /* Cart */
        .cart-link {
            position: relative; width: 36px; height: 36px; border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,.18); background: rgba(255,255,255,.06);
            color: rgba(255,255,255,.65);
            display: inline-flex; align-items: center; justify-content: center;
            text-decoration: none; transition: .2s; flex-shrink: 0;
        }
        .cart-link:hover { border-color: var(--pink); color: var(--pink); background: rgba(232,62,140,.1); }
        .cart-badge {
            position: absolute; top: -5px; right: -5px;
            min-width: 17px; height: 17px; border-radius: 999px;
            background: var(--pink); color: #fff;
            font-size: 9px; font-weight: 700; line-height: 17px; text-align: center;
            padding: 0 3px; border: 2px solid #1a1a2e;
        }

        /* Language pill */
        .nav-lang-wrap { position: relative; margin-left: 2px; }
        .nav-lang-pill {
            display: flex; align-items: center; gap: 5px;
            border: 1.5px solid rgba(255,255,255,.18); border-radius: 20px;
            padding: 5px 11px 5px 8px; font-size: 13px; font-weight: 600;
            color: rgba(255,255,255,.75); cursor: pointer; background: rgba(255,255,255,.06);
            transition: border-color .2s; user-select: none; white-space: nowrap;
        }
        .nav-lang-pill:hover { border-color: rgba(255,255,255,.4); }
        .nav-lang-flag  { font-size: 16px; line-height: 1; }
        .nav-lang-code  { font-size: 12.5px; font-weight: 700; color: rgba(255,255,255,.75); letter-spacing: .02em; }
        .nav-lang-chevron { font-size: 9px; color: rgba(255,255,255,.4); margin-left: 1px; transition: transform .2s; }
        .nav-lang-wrap.open .nav-lang-chevron { transform: rotate(180deg); }
        .nav-lang-drop {
            display: none; position: absolute; top: calc(100% + 6px); right: 0;
            background: #fff; border: 1px solid #e8e8e8; border-radius: 12px;
            min-width: 140px; box-shadow: 0 8px 28px rgba(0,0,0,.11);
            z-index: 9999; overflow: hidden; padding: 4px 0;
        }
        .nav-lang-wrap.open .nav-lang-drop { display: block; }
        .nav-lang-opt {
            display: flex; align-items: center; gap: 9px;
            padding: 10px 16px; font-size: 13.5px; font-weight: 500;
            color: #444; text-decoration: none; transition: background .15s;
        }
        .nav-lang-opt:hover { background: rgba(232,62,140,.07); color: var(--pink); }
        .nav-lang-opt.active { color: var(--pink); font-weight: 700; }
        .nav-lang-opt-flag { font-size: 18px; }

        /* Book Now button */
        .nav-book-btn {
            display: inline-flex; align-items: center; gap: 7px;
            background: var(--pink); color: #fff !important;
            padding: 9px 20px; border-radius: 8px; font-size: 13.5px; font-weight: 700;
            text-decoration: none; transition: .22s; white-space: nowrap;
            box-shadow: 0 4px 16px rgba(232,62,140,.35); margin-left: 6px; flex-shrink: 0;
        }
        .nav-book-btn:hover { background: var(--pink-dark); transform: translateY(-1px); box-shadow: 0 6px 22px rgba(232,62,140,.45); color: #fff !important; }
        .nav-book-btn i { font-size: 13px; }

        /* User chip (logged in) */
        .nav-user-chip {
            display: flex; align-items: center; gap: 8px;
            background: rgba(232,62,140,.1); border: 1.5px solid rgba(232,62,140,.25);
            border-radius: 40px; padding: 3px 12px 3px 3px;
            text-decoration: none; flex-shrink: 0;
        }
        .nav-user-avatar {
            width: 28px; height: 28px; border-radius: 50%;
            overflow: hidden; flex-shrink: 0; background: var(--pink);
        }
        .nav-user-avatar img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .nav-user-name { font-size: 12.5px; font-weight: 600; color: rgba(255,255,255,.85); }
        .btn-logout-nav {
            width: 32px; height: 32px; border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,.18); background: rgba(255,255,255,.06);
            color: rgba(255,255,255,.65); font-size: 13px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: .2s; flex-shrink: 0;
        }
        .btn-logout-nav:hover { border-color: var(--pink); color: var(--pink); background: rgba(232,62,140,.1); }

        /* Role badges */
        .role-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 10px; padding: 2px 7px; border-radius: 20px; font-weight: 600; letter-spacing: .04em; }
        .role-admin    { background: rgba(107,45,62,.1);   color: #6b2d3e; }
        .role-prest    { background: rgba(200,131,106,.14); color: #a5614b; }
        .role-employee { background: rgba(201,169,110,.16); color: #7a5b1e; }
        .role-client   { background: rgba(233,30,140,.14); color: #e91e8c; }

        /* Hamburger */
        .nav-hamburger {
            display: none; width: 38px; height: 38px;
            border: 1.5px solid rgba(255,255,255,.2); border-radius: 8px;
            background: rgba(255,255,255,.07);
            align-items: center; justify-content: center;
            cursor: pointer; font-size: 16px; color: rgba(255,255,255,.85);
            margin-left: 8px; transition: .2s; flex-shrink: 0;
        }
        .nav-hamburger:hover { background: rgba(232,62,140,.15); border-color: var(--pink); color: var(--pink); }

        /* ═══ MOBILE DRAWER (same as home layout) ════════ */
        .drawer-bg {
            display: none; position: fixed; inset: 0;
            background: rgba(10,8,26,.55); z-index: 980; backdrop-filter: blur(3px);
        }
        .drawer-bg.open { display: block; }
        .drawer-panel {
            position: fixed; top: 0; right: -320px;
            width: 300px; height: 100dvh; background: #fff; z-index: 990;
            transition: right .32s cubic-bezier(.4,0,.2,1);
            display: flex; flex-direction: column;
            box-shadow: -6px 0 40px rgba(0,0,0,.18); overflow-y: auto;
        }
        .drawer-panel.open { right: 0; }
        .drawer-top {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px 18px; border-bottom: 1px solid #f0f0f0; background: #1a1a2e;
        }
        .drawer-x {
            width: 34px; height: 34px;
            border: 1.5px solid rgba(255,255,255,.2); background: rgba(255,255,255,.07);
            border-radius: 8px; cursor: pointer; font-size: 14px; color: rgba(255,255,255,.7);
            display: flex; align-items: center; justify-content: center; transition: .2s;
        }
        .drawer-x:hover { background: rgba(232,62,140,.2); border-color: var(--pink); color: var(--pink); }
        .drawer-nav { padding: 12px 14px; flex: 1; }
        .drawer-nav a {
            display: flex; align-items: center; gap: 11px; padding: 11px 14px;
            font-size: 14.5px; font-weight: 500; color: #3a3a5c;
            text-decoration: none; border-radius: 10px; margin-bottom: 3px; transition: .18s;
        }
        .drawer-nav a i { width: 18px; text-align: center; color: #aaa; font-size: 14px; transition: .18s; }
        .drawer-nav a:hover, .drawer-nav a.active { background: rgba(232,62,140,.08); color: var(--pink); }
        .drawer-nav a:hover i, .drawer-nav a.active i { color: var(--pink); }
        .drawer-sep { height: 1px; background: #f0f0f0; margin: 8px 14px; }
        .drawer-lang { padding: 10px 14px 14px; }
        .drawer-lang-label {
            font-size: 10.5px; font-weight: 700; letter-spacing: .14em;
            text-transform: uppercase; color: #bbb; padding: 0 6px; margin-bottom: 10px;
        }
        .drawer-lang-opts { display: flex; gap: 8px; }
        .drawer-lang-opt {
            flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px;
            padding: 10px 8px; border-radius: 10px; border: 1.5px solid #eee; background: #fafafa;
            text-decoration: none; font-size: 11px; font-weight: 600; color: #666; transition: .2s;
        }
        .drawer-lang-opt .dl-flag { font-size: 22px; line-height: 1; }
        .drawer-lang-opt .dl-code { font-size: 11px; font-weight: 700; letter-spacing: .04em; }
        .drawer-lang-opt:hover { border-color: var(--pink); color: var(--pink); background: rgba(232,62,140,.04); }
        .drawer-lang-opt.active { border-color: var(--pink); background: rgba(232,62,140,.08); color: var(--pink); }
        .drawer-lang-opt.active .dl-code { color: var(--pink); }
        .drawer-cta {
            margin: 6px 16px 20px;
            display: flex; align-items: center; justify-content: center; gap: 9px;
            background: var(--pink); color: #fff !important; padding: 14px; border-radius: 12px;
            font-size: 14.5px; font-weight: 700; text-decoration: none;
            box-shadow: 0 6px 20px rgba(232,62,140,.35); transition: .2s;
        }
        .drawer-cta:hover { background: var(--pink-dark); transform: translateY(-1px); }
        .drawer-logout-btn {
            margin: 0 16px 16px;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            background: rgba(232,62,140,.08); color: var(--pink) !important;
            padding: 13px; border-radius: 12px; font-size: 14px; font-weight: 600;
            border: 1.5px solid rgba(232,62,140,.2); cursor: pointer; width: calc(100% - 32px);
            transition: .2s;
        }
        .drawer-logout-btn:hover { background: var(--pink); color: #fff !important; }

        /* Responsive nav */
        @media (max-width: 991px) {
            .nav-bar { padding: 0 20px; height: 62px; }
            .nav-links { display: none; }
            .nav-hamburger { display: flex; }
            .nav-logo { margin-right: 0; }
            .nav-user-chip .nav-user-name { display: none; }
        }
        @media (max-width: 767px) {
            .nav-bar { padding: 0 16px; height: 58px; }
            .nav-lang-wrap { display: none; }
            .nav-book-btn { display: none; }
        }
        @media (max-width: 400px) {
            .nav-bar { padding: 0 12px; }
            .nav-logo-sub, .nav-logo-salon { display: none; }
        }

        /* ─── CONTENT ─────────────────────────────────── */
        .content { flex: 1; padding: clamp(20px, 4vw, 40px) clamp(16px, 5vw, 50px); }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .page-title-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: #e91e8c;
            margin-bottom: 4px;
        }
        .page-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1.1;
        }

        /* Hero card */
        .hero-card {
            background: linear-gradient(130deg, var(--wine-dark) 0%, var(--wine) 55%, var(--rose-deep) 100%);
            border-radius: 24px;
            padding: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            overflow: hidden;
            position: relative;
        }
        .hero-card::before {
            content: '';
            position: absolute;
            right: -60px; top: -60px;
            width: 280px; height: 280px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
        }
        .hero-card::after {
            content: '';
            position: absolute;
            right: 80px; bottom: -80px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(201,169,110,.08);
        }
        .hero-text { position: relative; }
        .hero-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .14em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 12px;
        }
        .hero-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 38px;
            font-weight: 700;
            color: white;
            line-height: 1.1;
            margin-bottom: 14px;
        }
        .hero-title em { color: var(--gold-light); font-style: italic; }
        .hero-desc {
            font-size: 14px;
            color: rgba(255,255,255,.7);
            max-width: 360px;
            line-height: 1.7;
            margin-bottom: 28px;
        }
        .hero-btns { display: flex; gap: 12px; flex-wrap: wrap; }
        .btn-gold {
            background: linear-gradient(135deg, var(--gold), #b5873a);
            color: var(--wine-dark);
            border: none;
            padding: 12px 26px;
            border-radius: 30px;
            font-size: 13.5px;
            font-weight: 700;
            cursor: pointer;
            transition: .25s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            letter-spacing: .03em;
            box-shadow: 0 4px 16px rgba(201,169,110,.4);
        }
        .btn-gold:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(201,169,110,.5); color: var(--wine-dark); }
        .btn-ghost-white {
            background: rgba(255,255,255,.1);
            color: white;
            border: 1.5px solid rgba(255,255,255,.3);
            padding: 11px 22px;
            border-radius: 30px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: .25s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-ghost-white:hover { background: rgba(255,255,255,.18); color: white; }
        .hero-deco {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
            position: relative;
        }
        .hero-stat-card {
            background: rgba(255,255,255,.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,.15);
            border-radius: 18px;
            padding: 16px 22px;
            text-align: center;
            min-width: 130px;
        }
        .hero-stat-num {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--gold-light);
            line-height: 1;
        }
        .hero-stat-label {
            font-size: 11px;
            color: rgba(255,255,255,.6);
            margin-top: 4px;
            font-weight: 500;
            letter-spacing: .04em;
        }

        /* Service cards */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-top: 30px;
        }
        .service-card {
            background: white;
            border-radius: 24px;
            padding: 28px 24px;
            border: 1.5px solid var(--champagne);
            text-align: center;
            transition: all .35s cubic-bezier(.4, 0, .2, 1);
            cursor: pointer;
            text-decoration: none;
            display: block;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(107,45,62,.06), 0 1px 3px rgba(0,0,0,.08);
        }
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(201,169,110,.04), rgba(200,131,106,.04));
            opacity: 0;
            transition: opacity .35s ease;
            pointer-events: none;
        }
        .service-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(107,45,62,.15), 0 8px 20px rgba(200,131,106,.12);
            border-color: var(--rose);
        }
        .service-card:hover::before {
            opacity: 1;
        }
        .service-icon {
            width: 64px; height: 64px;
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 26px;
            margin: 0 auto 18px;
            box-shadow: inset 0 0 0 1px rgba(255,255,255,.35), 0 10px 18px rgba(200,126,90,.08);
            transition: transform .35s ease, box-shadow .35s ease, background .35s ease;
        }
        .service-card:hover .service-icon {
            transform: scale(1.08);
        }
        .si-rose  { background: linear-gradient(145deg, rgba(232,157,138,.18), rgba(200,126,90,.2)); color: var(--rose-deep); }
        .si-gold  { background: linear-gradient(145deg, rgba(235,212,170,.22), rgba(201,169,110,.26)); color: #8a6520; }
        .si-wine  { background: linear-gradient(145deg, rgba(171,118,131,.14), rgba(107,45,62,.18)); color: var(--wine); }
        .si-cream { background: linear-gradient(145deg, rgba(245,236,219,.65), rgba(240,224,195,.8)); color: var(--rose-deep); }
        .service-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--wine);
            margin-bottom: 8px;
            transition: color .35s ease;
        }
        .service-card:hover .service-name {
            color: var(--rose);
        }
        .service-desc {
            font-size: 13px;
            color: var(--warm-grey);
            line-height: 1.7;
            min-height: 3.6em;
            margin: 0 auto 18px;
            max-width: 280px;
        }
        .service-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin-top: 18px;
            padding-top: 16px;
            border-top: 1px solid rgba(221,199,184,.45);
        }
        .service-price {
            font-size: 14px;
            font-weight: 800;
            color: var(--rose-deep);
        }
        .service-price span {
            font-weight: 800;
            color: var(--rose-deep);
            font-size: 16px;
        }
        .service-dur {
            font-size: 13px;
            color: var(--warm-grey);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .service-dur i {
            font-size: 0.95rem;
            color: var(--rose);
        }

        /* Card pro générique */
        .card-pro {
            background: white;
            border: none;
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 10px 35px rgba(0,0,0,.05);
        }

        /* ─── FOOTER ─────────────────────────────────────────────── */
        footer {
            background: #0b0818;
            color: rgba(255,255,255,.58);
            margin-top: auto;
            border-top: 1px solid rgba(233,30,140,.18);
        }

        /* CTA / Newsletter bar */
        .footer-cta-bar {
            padding: 46px 52px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
            border-bottom: 1px solid rgba(233,30,140,.1);
            background: linear-gradient(135deg, rgba(233,30,140,.12) 0%, rgba(0,0,0,0) 65%);
        }
        .footer-cta-text h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.7rem;
            font-weight: 700;
            margin-bottom: 6px;
            background: linear-gradient(120deg, #ffffff 0%, #e91e8c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .footer-cta-text p { font-size: .83rem; color: rgba(255,255,255,.32); }

        .footer-nl-form {
            display: flex;
            gap: 8px;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(233,30,140,.25);
            border-radius: 8px;
            padding: 5px 5px 5px 18px;
            min-width: min(360px, 100%);
            width: 100%;
        }
        .footer-nl-form input {
            flex: 1; background: transparent; border: none; outline: none;
            color: white; font-size: .87rem;
        }
        .footer-nl-form input::placeholder { color: rgba(255,255,255,.25); }

        .footer-nl-btn {
            background: linear-gradient(135deg, #e91e8c, #c91a78);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: .82rem;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            transition: opacity .2s, transform .2s;
            display: inline-flex; align-items: center; gap: 7px;
        }
        .footer-nl-btn:hover { opacity: .86; transform: translateY(-1px); }

        /* Main grid */
        .footer-main {
            padding: 64px 52px 52px;
            display: grid;
            grid-template-columns: 2.1fr 1fr 1fr 1.5fr;
            gap: 54px;
        }
        .footer-logo-row {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }
        .footer-logo-icon {
            width: 52px; height: 52px;
            border-radius: 14px;
            background: linear-gradient(135deg, #e91e8c, #c91a78);
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            color: #ffffff;
            box-shadow: 0 8px 24px rgba(233,30,140,.25);
            flex-shrink: 0;
        }
        .footer-logo-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            line-height: 1;
        }
        .footer-logo-tag {
            font-size: 9px;
            color: rgba(255,255,255,.22);
            letter-spacing: .18em;
            text-transform: uppercase;
            margin-top: 5px;
        }
        .footer-desc {
            font-size: 13px;
            line-height: 1.8;
            color: rgba(255,255,255,.34);
            max-width: 280px;
            margin-bottom: 20px;
        }
        .footer-rating {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
        }
        .footer-rating-stars { color: #e91e8c; font-size: .82rem; letter-spacing: 2px; }
        .footer-rating-text  { font-size: .72rem; color: rgba(255,255,255,.27); }

        .footer-socials { display: flex; gap: 9px; }
        .footer-social {
            width: 38px; height: 38px;
            border-radius: 10px;
            background: rgba(255,255,255,.04);
            border: 1px solid rgba(255,255,255,.08);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,.38);
            font-size: 14px;
            text-decoration: none;
            transition: background .22s, border-color .22s, color .22s, transform .22s, box-shadow .22s;
        }
        .footer-social:hover {
            background: #e91e8c;
            border-color: #e91e8c;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(233,30,140,.35);
        }

        .footer-col-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 17px;
            font-weight: 700;
            color: rgba(255,255,255,.9);
            margin-bottom: 22px;
            padding-bottom: 12px;
            position: relative;
        }
        .footer-col-title::after {
            content: '';
            position: absolute;
            left: 0; bottom: 0;
            width: 28px; height: 2px;
            background: linear-gradient(90deg, #e91e8c, #ff6ab4);
            border-radius: 2px;
        }
        .footer-links { list-style: none; display: flex; flex-direction: column; gap: 11px; }
        .footer-links a {
            text-decoration: none;
            color: rgba(255,255,255,.34);
            font-size: 13px;
            transition: color .2s, padding-left .2s;
            display: flex; align-items: center; gap: 9px;
        }
        .footer-links a i { font-size: 9px; color: #e91e8c; opacity: .55; transition: opacity .2s; }
        .footer-links a:hover { color: #e91e8c; padding-left: 4px; }
        .footer-links a:hover i { opacity: 1; }

        .footer-contact-item {
            display: flex; align-items: flex-start; gap: 13px; margin-bottom: 16px;
        }
        .fci-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: rgba(233,30,140,.08);
            border: 1px solid rgba(233,30,140,.18);
            display: flex; align-items: center; justify-content: center;
            color: #e91e8c; font-size: 13px; flex-shrink: 0; margin-top: 2px;
        }
        .fci-text { font-size: 12.5px; line-height: 1.65; color: rgba(255,255,255,.34); }
        .fci-label {
            font-size: 9.5px; font-weight: 700; letter-spacing: .1em;
            text-transform: uppercase; color: rgba(255,255,255,.18); margin-bottom: 2px;
        }
        .footer-hours-table { margin-top: 18px; padding-top: 15px; border-top: 1px solid rgba(233,30,140,.12); }
        .footer-hours-row {
            display: flex; justify-content: space-between;
            font-size: 12px; margin-bottom: 7px; color: rgba(255,255,255,.26);
        }
        .footer-hours-row .open   { color: #6ed98a; font-weight: 600; }
        .footer-hours-row .closed { color: rgba(255,255,255,.15); }

        .footer-divider { border: none; border-top: 1px solid rgba(255,255,255,.06); margin: 0 52px; }

        .footer-bottom {
            padding: 20px 52px;
            display: flex; align-items: center; justify-content: space-between; gap: 16px;
        }
        .footer-copy { font-size: 12px; color: rgba(255,255,255,.2); }
        .footer-copy a { color: #e91e8c; text-decoration: none; opacity: .75; transition: opacity .2s; }
        .footer-copy a:hover { opacity: 1; }
        .footer-trust {
            display: inline-flex; align-items: center; gap: 6px;
            font-size: 11px; color: rgba(255,255,255,.2);
            border: 1px solid rgba(255,255,255,.07);
            padding: 5px 13px; border-radius: 20px;
        }
        .footer-trust i { color: #e91e8c; font-size: 10px; }
        .footer-bottom-links { display: flex; gap: 20px; }
        .footer-bottom-links a {
            font-size: 11px; color: rgba(255,255,255,.2); text-decoration: none; transition: color .2s;
        }
        .footer-bottom-links a:hover { color: #e91e8c; }

        /* Booking badge */
        .booking-badge {
            position: fixed;
            bottom: 30px; right: 30px;
            z-index: 800;
            background: linear-gradient(135deg, #e91e8c, #c91a78);
            color: #ffffff;
            padding: 14px 22px;
            border-radius: 50px;
            font-size: 13.5px;
            font-weight: 700;
            box-shadow: 0 6px 28px rgba(233,30,140,.45);
            display: flex; align-items: center; gap: 9px;
            cursor: pointer; transition: .28s;
            text-decoration: none;
            animation: float 3s ease-in-out infinite;
        }
        .booking-badge:hover {
            transform: translateY(-3px) scale(1.03);
            box-shadow: 0 10px 35px rgba(233,30,140,.6);
            color: #ffffff; animation: none;
        }
        @keyframes float {
            0%,100% { transform: translateY(0); }
            50%      { transform: translateY(-5px); }
        }

        @media(max-width: 1100px) {
            .footer-main { grid-template-columns: 1fr 1fr; gap: 38px; }
            .footer-nl-form { min-width: 260px; }
        }
        @media(max-width: 900px) {
            .footer-cta-bar { flex-direction: column; align-items: flex-start; padding: 32px 24px; }
            .footer-nl-form { min-width: 0; width: 100%; }
            .footer-main { padding: 40px 24px 32px; grid-template-columns: 1fr; gap: 32px; }
            .footer-divider { margin: 0 24px; }
            .footer-bottom { padding: 18px 24px; flex-direction: column; gap: 14px; text-align: center; }
            .footer-trust { display: none; }
        }

        .logo-badge {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            border: 2.5px solid rgba(233,30,140,.55);
            box-shadow: 0 0 0 3px rgba(233,30,140,.15), 0 4px 16px rgba(0,0,0,.4);
            transition: transform .3s, box-shadow .3s;
        }
        .logo-badge:hover {
            transform: scale(1.05);
            box-shadow: 0 0 0 4px rgba(233,30,140,.28), 0 6px 20px rgba(0,0,0,.5);
        }
        .logo-badge img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* ─── RESPONSIVE ─────────────────────────────── */
        @media(max-width: 1100px) {
            .services-grid { grid-template-columns: repeat(3, 1fr); }
            .footer-main { grid-template-columns: 1fr 1fr; }
        }
        @media(max-width: 900px) {
            .services-grid { grid-template-columns: repeat(2, 1fr); }
            .content { padding: 28px 20px; }
            .hero-card { flex-direction: column; padding: 34px 28px; }
            .hero-deco { flex-direction: row; }
            .hero-title { font-size: 30px; }
            .footer-main { padding: 40px 24px 32px; grid-template-columns: 1fr; gap: 32px; }
            .footer-bottom { padding: 18px 24px; flex-direction: column; gap: 12px; text-align: center; }
        }
        @media(max-width: 768px) {
            .content { padding: 20px 16px; }
            .booking-badge { bottom: 80px; right: 16px; padding: 11px 16px; font-size: 12px; }
            .footer-cta-bar { padding: 28px 20px; gap: 20px; }
            .footer-nl-form { min-width: 0; width: 100%; }
            .hero-btns { flex-wrap: wrap; gap: 10px; }
            .hero-desc { font-size: 13px; }
            .footer-bottom-links { flex-wrap: wrap; justify-content: center; gap: 12px; }
        }
        @media(max-width: 600px) {
            .services-grid { grid-template-columns: 1fr; }
            .footer-bottom-links { flex-direction: column; align-items: center; gap: 10px; }
        }
        @media(max-width: 480px) {
            .content { padding: 16px 12px; }
            .hero-card { padding: 24px 18px; }
            .hero-title { font-size: 26px; }
            .hero-stat-card { padding: 12px 16px; min-width: 100px; }
            .hero-stat-num { font-size: 26px; }
            .hero-btns { flex-direction: column; align-items: stretch; }
            .hero-btns .btn-gold,
            .hero-btns .btn-ghost-white { text-align: center; justify-content: center; }
        }
        @media(max-width: 360px) {
            .content { padding: 12px 10px; }
            .hero-card { padding: 18px 14px; border-radius: 18px; }
            .hero-title { font-size: 22px; }
            .hero-stat-card { padding: 10px 12px; min-width: 80px; }
            .hero-stat-num { font-size: 22px; }
            .footer-nl-form { flex-direction: column; padding: 12px; }
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

    {{-- Header --}}
    <div class="drawer-top">
        <a href="{{ route('home') }}" class="nav-logo" style="margin:0;" onclick="drawerClose()">
            <div class="nav-logo-flame">
                <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair Braiding">
            </div>
            <div class="nav-logo-words">
                <span class="nav-logo-marol" style="color:#fff;">Marol</span>
                <span class="nav-logo-sub">Hair Braiding</span>
                <span class="nav-logo-salon">Salon</span>
            </div>
        </a>
        <button class="drawer-x" onclick="drawerClose()"><i class="fa-solid fa-xmark"></i></button>
    </div>

    {{-- Nav links --}}
    <div class="drawer-nav">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" onclick="drawerClose()">
            <i class="fa-solid fa-house"></i> {{ __('messages.nav_link_home') }}
        </a>
        <a href="{{ route('booking.start') }}" class="{{ request()->routeIs('booking.*') ? 'active' : '' }}" onclick="drawerClose()">
            <i class="fa-regular fa-calendar-check"></i> {{ __('messages.nav_link_appointment') }}
        </a>
        <a href="{{ route('stylists.index') }}" class="{{ request()->routeIs('stylists.*') ? 'active' : '' }}" onclick="drawerClose()">
            <i class="fa-solid fa-user-tie"></i> {{ __('messages.nav_link_stylists') }}
        </a>
        <a href="{{ route('gallery.index') }}" class="{{ request()->routeIs('gallery.*') ? 'active' : '' }}" onclick="drawerClose()">
            <i class="fa-solid fa-images"></i> {{ __('messages.nav_link_gallery') }}
        </a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}" onclick="drawerClose()">
            <i class="fa-solid fa-circle-info"></i> {{ __('messages.nav_link_about') }}
        </a>
        <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}" onclick="drawerClose()">
            <i class="fa-solid fa-envelope"></i> {{ __('messages.nav_link_contact') }}
        </a>
        @auth
            @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}" onclick="drawerClose()">
                <i class="fa-solid fa-chart-line"></i> {{ __('messages.dashboard') }}
            </a>
            @elseif(auth()->user()->role === 'employee')
            <a href="{{ route('employee.dashboard') }}" class="{{ request()->routeIs('employee.*') ? 'active' : '' }}" onclick="drawerClose()">
                <i class="fa-solid fa-gauge-high"></i> {{ __('messages.my_dashboard') }}
            </a>
            @else
            <a href="{{ route('client.dashboard') }}" class="{{ request()->routeIs('client.*') ? 'active' : '' }}" onclick="drawerClose()">
                <i class="fa-solid fa-gauge-high"></i> {{ __('messages.dashboard') }}
            </a>
            @endif
        @else
            <a href="{{ route('login') }}" onclick="drawerClose()">
                <i class="fa-solid fa-right-to-bracket"></i> {{ __('messages.login') }}
            </a>
            <a href="{{ route('register') }}" onclick="drawerClose()">
                <i class="fa-solid fa-user-plus"></i> {{ __('messages.register') }}
            </a>
        @endauth
    </div>

    <div class="drawer-sep"></div>

    {{-- Language --}}
    @php $loc = app()->getLocale(); @endphp
    <div class="drawer-lang">
        <div class="drawer-lang-label">{{ __('messages.nav_lang_label') }}</div>
        <div class="drawer-lang-opts">
            <a href="{{ route('locale.switch','en') }}" class="drawer-lang-opt {{ $loc==='en'?'active':'' }}">
                <span class="dl-flag">🇺🇸</span><span class="dl-code">EN</span>
            </a>
            <a href="{{ route('locale.switch','fr') }}" class="drawer-lang-opt {{ $loc==='fr'?'active':'' }}">
                <span class="dl-flag">🇫🇷</span><span class="dl-code">FR</span>
            </a>
            <a href="{{ route('locale.switch','es') }}" class="drawer-lang-opt {{ $loc==='es'?'active':'' }}">
                <span class="dl-flag">🇪🇸</span><span class="dl-code">ES</span>
            </a>
        </div>
    </div>

    @auth
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="drawer-logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i> {{ __('messages.logout') }}
        </button>
    </form>
    @else
    <a href="{{ route('booking.start') }}" class="drawer-cta" onclick="drawerClose()">
        <i class="fa-regular fa-calendar-check"></i> {{ __('messages.nav_btn_book') }}
    </a>
    @endauth

</div>

{{-- ══ NAVBAR (remplacée par partials.main-navbar inclus en début de body) ══ --}}
<nav class="nav-bar" style="display:none!important">

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

    <ul class="nav-links">
        <li><a href="{{ route('home') }}"           class="{{ request()->routeIs('home')       ? 'active' : '' }}">{{ __('messages.nav_link_home') }}</a></li>
        <li><a href="{{ route('booking.start') }}"  class="{{ request()->routeIs('booking.*')  ? 'active' : '' }}">{{ __('messages.nav_link_appointment') }}</a></li>
        <li><a href="{{ route('stylists.index') }}" class="{{ request()->routeIs('stylists.*') ? 'active' : '' }}">{{ __('messages.nav_link_stylists') }}</a></li>
        <li><a href="{{ route('gallery.index') }}"  class="{{ request()->routeIs('gallery.*')  ? 'active' : '' }}">{{ __('messages.nav_link_gallery') }}</a></li>
        <li><a href="{{ route('about') }}"          class="{{ request()->routeIs('about')      ? 'active' : '' }}">{{ __('messages.nav_link_about') }}</a></li>
        <li><a href="{{ route('contact') }}"        class="{{ request()->routeIs('contact')    ? 'active' : '' }}">{{ __('messages.nav_link_contact') }}</a></li>
    </ul>

    <div class="nav-right">

        {{-- Language picker --}}
        @php $app_loc = app()->getLocale(); @endphp
        <div class="nav-lang-wrap" id="navLangWrap">
            <div class="nav-lang-pill" onclick="navLangToggle()">
                <span class="nav-lang-flag">
                    @if($app_loc==='fr') 🇫🇷
                    @elseif($app_loc==='en') 🇺🇸
                    @else 🇪🇸
                    @endif
                </span>
                <span class="nav-lang-code">{{ strtoupper($app_loc) }}</span>
                <i class="fa-solid fa-chevron-down nav-lang-chevron"></i>
            </div>
            <div class="nav-lang-drop">
                <a href="{{ route('locale.switch','en') }}" class="nav-lang-opt {{ $app_loc==='en'?'active':'' }}">
                    <span class="nav-lang-opt-flag">🇺🇸</span> {{ __('messages.nav_lang_en') }}
                </a>
                <a href="{{ route('locale.switch','fr') }}" class="nav-lang-opt {{ $app_loc==='fr'?'active':'' }}">
                    <span class="nav-lang-opt-flag">🇫🇷</span> {{ __('messages.nav_lang_fr') }}
                </a>
                <a href="{{ route('locale.switch','es') }}" class="nav-lang-opt {{ $app_loc==='es'?'active':'' }}">
                    <span class="nav-lang-opt-flag">🇪🇸</span> {{ __('messages.nav_lang_es') }}
                </a>
            </div>
        </div>

        {{-- Auth --}}
        @auth
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'employee' ? route('employee.dashboard') : route('client.dashboard')) }}" class="nav-user-chip">
                <div class="nav-user-avatar">
                    <img src="{{ auth()->user()->photo ? asset('storage/'.auth()->user()->photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=e91e8c&color=fff' }}" alt="">
                </div>
                <span class="nav-user-name">{{ auth()->user()->name }}</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display:contents">
                @csrf
                <button type="submit" class="btn-logout-nav" title="{{ __('messages.logout') }}">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        @else
            <a href="{{ route('booking.start') }}" class="nav-book-btn">
                <i class="fa-regular fa-calendar-check"></i> {{ __('messages.nav_btn_book') }}
            </a>
        @endauth

        <button class="nav-hamburger" onclick="drawerOpen()">
            <i class="fa-solid fa-bars"></i>
        </button>

    </div>
</nav>

{{-- ═══════════════════════════════════════════════ --}}
{{--  CONTENU DE LA PAGE                             --}}
{{-- ═══════════════════════════════════════════════ --}}
<main class="content">

    @hasSection('page-header')
        <div class="page-header">
            <div class="page-title-wrap">
                <div class="page-title-eyebrow">
                    <i class="fa-solid fa-hand-sparkles" style="margin-right:6px;"></i>
                    @yield('page-eyebrow', __('messages.brand_name'))
                </div>
                <h1 class="page-title">@yield('title')</h1>
            </div>
            @yield('page-actions')
        </div>
    @endif

    @yield('content')

</main>

{{-- ═══════════════════════════════════════════════ --}}
{{--  FOOTER                                         --}}
{{-- ═══════════════════════════════════════════════ --}}
@include('partials.footer')

{{-- ═══════════════════════════════════════════════ --}}
{{--  BOUTON FLOTTANT RDV                            --}}
{{-- ═══════════════════════════════════════════════ --}}
{{-- <a href="{{ route('booking.start') }}" class="booking-badge">
    <i class="fa-solid fa-calendar-check"></i>
    {{ __('messages.reserve') }}
</a> --}}

{{-- ═══════════════════════════════════════════════ --}}
{{--  SCRIPTS                                        --}}
{{-- ═══════════════════════════════════════════════ --}}
<script>
    function drawerOpen()  { document.getElementById('drawerPanel').classList.add('open'); document.getElementById('drawerBg').classList.add('open'); document.body.style.overflow='hidden'; }
    function drawerClose() { document.getElementById('drawerPanel').classList.remove('open'); document.getElementById('drawerBg').classList.remove('open'); document.body.style.overflow=''; }
    function navLangToggle() { document.getElementById('navLangWrap').classList.toggle('open'); }
    document.addEventListener('click', function(e) {
        var w = document.getElementById('navLangWrap');
        if (w && !w.contains(e.target)) w.classList.remove('open');
    });

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
@include('partials.toast')
</body>
</html>