<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Marol Hair Braiding')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * { scroll-behavior: smooth; box-sizing: border-box;}

        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(212,175,55,0.15), transparent 30%),
                radial-gradient(circle at bottom right, rgba(255,215,0,0.12), transparent 30%),
                #0f0f0f;
        }

        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-thumb {
            background: linear-gradient(to bottom, #d4af37, #f5d76e);
            border-radius: 20px;
        }

        .glass {
            background: rgba(255,255,255,0.06);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.08);
        }

        .gold-text {
            background: linear-gradient(to right, #d4af37, #f8e08e, #b8860b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link {
            position: relative;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 20px;
            border-radius: 18px;
            color: #e5e7eb;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #fff;
            background: rgba(255,255,255,0.08);
            transform: translateX(2px);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #d4af37, #f5d76e);
            color: #111827;
            box-shadow: 0 16px 32px rgba(212,175,55,0.18);
            font-weight: 700;
        }

        .drawer-nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            border-radius: 16px;
            color: #e5e7eb;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .drawer-nav-link:hover {
            background: rgba(255,255,255,0.08);
            color: #fff;
        }

        .drawer-nav-link.active {
            background: linear-gradient(135deg, #d4af37, #f5d76e);
            color: #111827;
            font-weight: 700;
        }

        .premium-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,215,0,0.18);
            backdrop-filter: blur(16px);
            border-radius: 28px;
            box-shadow: 0 14px 45px rgba(0,0,0,0.28);
        }

        .btn-gold {
            background: linear-gradient(to right, #d4af37, #f5d76e);
            color: #111827;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-gold:hover {
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 10px 30px rgba(212,175,55,0.4);
        }

        .fade-in {
            animation: fade .5s ease;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Cart link in topbar */
        .topbar-cart {
            position: relative; width: 36px; height: 36px; border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,.18); background: rgba(255,255,255,.06);
            color: rgba(255,255,255,.65);
            display: inline-flex; align-items: center; justify-content: center;
            text-decoration: none; transition: .2s; flex-shrink: 0;
        }
        .topbar-cart:hover { border-color: #e83e8c; color: #e83e8c; background: rgba(232,62,140,.1); }
        .topbar-cart-badge {
            position: absolute; top: -4px; right: -4px;
            min-width: 16px; height: 16px; border-radius: 999px;
            background: #e83e8c; color: #fff;
            font-size: 9px; font-weight: 700; line-height: 16px; text-align: center;
            padding: 0 3px; border: 2px solid #1a1a2e;
        }

        /* Lang pill dropdown in topbar */
        .topbar-lang-wrap { position: relative; }
        .topbar-lang-pill {
            display: flex; align-items: center; gap: 5px;
            border: 1.5px solid rgba(255,255,255,.18); border-radius: 20px;
            padding: 5px 11px 5px 8px; font-size: 13px; font-weight: 600;
            color: rgba(255,255,255,.75); cursor: pointer; background: rgba(255,255,255,.06);
            transition: border-color .2s; user-select: none; white-space: nowrap;
        }
        .topbar-lang-pill:hover { border-color: rgba(255,255,255,.4); }
        .topbar-lang-flag  { font-size: 16px; line-height: 1; }
        .topbar-lang-code  { font-size: 12.5px; font-weight: 700; color: rgba(255,255,255,.75); }
        .topbar-lang-chevron { font-size: 9px; color: rgba(255,255,255,.4); margin-left: 1px; transition: transform .2s; }
        .topbar-lang-wrap.open .topbar-lang-chevron { transform: rotate(180deg); }
        .topbar-lang-drop {
            display: none; position: absolute; top: calc(100% + 6px); right: 0;
            background: #fff; border: 1px solid #e8e8e8; border-radius: 12px;
            min-width: 140px; box-shadow: 0 8px 28px rgba(0,0,0,.11);
            z-index: 9999; overflow: hidden; padding: 4px 0;
        }
        .topbar-lang-wrap.open .topbar-lang-drop { display: block; }
        .topbar-lang-opt {
            display: flex; align-items: center; gap: 9px; padding: 10px 16px;
            font-size: 13.5px; font-weight: 500; color: #444;
            text-decoration: none; transition: background .15s;
        }
        .topbar-lang-opt:hover { background: rgba(232,62,140,.07); color: #e83e8c; }
        .topbar-lang-opt.active { color: #e83e8c; font-weight: 700; }
        .topbar-lang-opt-flag { font-size: 18px; }

        .lang-switch {
            border-radius: 999px;
            padding: 10px 14px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            color: #fbbf24;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s ease, transform .2s ease;
        }

        .lang-switch:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-1px);
        }

        /* ── Lang pills in white topbar ── */
        .lang-pills {
            display: flex; align-items: center; gap: 4px;
            background: #f0f1ff;
            border: 1px solid #ddd6fe;
            border-radius: 30px; padding: 4px 6px;
        }
        .lang-pill {
            display: flex; align-items: center; gap: 5px;
            padding: 5px 10px; border-radius: 20px;
            border: none; background: transparent;
            color: #6b21a8;
            font-size: 12px; font-weight: 600;
            cursor: pointer; text-decoration: none;
            transition: background .2s, color .2s; white-space: nowrap;
        }
        .lang-pill .flag { font-size: 16px; line-height: 1; }
        .lang-pill:hover { background: rgba(107,33,168,.1); color: #4c1d95; }
        .lang-pill.active { background: linear-gradient(135deg, #e91e8c, #c0156d); color: #fff; }

        /* ── Lang pills in dark drawer ── */
        .drawer-lang-pills {
            display: flex; gap: 6px; padding: 6px 2px;
        }
        .drawer-lang-pill {
            flex: 1; text-align: center; padding: 9px 4px;
            border-radius: 10px; font-size: 13px; font-weight: 600;
            text-decoration: none; transition: .2s;
            background: rgba(255,255,255,.06); color: rgba(255,255,255,.6);
        }
        .drawer-lang-pill:hover { background: rgba(233,30,140,.15); color: #fff; }
        .drawer-lang-pill.active { background: #e91e8c; color: #fff; }

        .theme-toggle {
            width: 44px;
            height: 44px;
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.08);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform .2s ease, background .2s ease;
        }

        .theme-toggle:hover {
            transform: translateY(-1px);
            background: rgba(255,255,255,0.16);
        }

        @keyframes fade {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ════════════════════════════
           MOBILE TOPBAR
        ════════════════════════════ */
        .mob-topbar {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(15,15,15,0.92);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(212,175,55,0.2);
        }

        .mob-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mob-logo img {
            width: 100px;
            height: 36px;
            object-fit: contain;
            border: 2px solid #d4af37;
            box-shadow: 0 0 18px rgba(212,175,55,0.25);
        }

        .mob-logo-name {
            font-size: 19px;
            font-weight: 800;
            background: linear-gradient(to right, #d4af37, #f8e08e, #b8860b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .mob-logo-sub {
            font-size: 9px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .12em;
        }

        .mob-burger {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: rgba(212,175,55,0.1);
            border: 1px solid rgba(212,175,55,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #d4af37;
            font-size: 18px;
            transition: background .2s;
            flex-shrink: 0;
        }

        .mob-burger:hover { background: rgba(212,175,55,0.2); }

        /* ════════════════════════════
           OVERLAY
        ════════════════════════════ */
.drawer-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.55);
    z-index: 200;
    opacity: 0;
    transition: opacity .3s;
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
    pointer-events: none;
}

.drawer-overlay.visible {
    opacity: 1;
    pointer-events: auto;
}

@media (max-width: 980px) {
    aside { display: none !important; }
    .md\:ml-72 { margin-left: 0 !important; }
    .content { margin-left: 0; padding: 20px; }
    .mob-topbar { display: flex; }
    .desktop-header { display: none !important; }
    .drawer-overlay { display: block; pointer-events: none; }
    .admin-grid { grid-template-columns: 1fr; }
    .admin-card.small { grid-column: span 1; }
}

@media (max-width: 480px) {
    .mob-topbar { padding: 12px 14px; }
    .mob-logo img { width: 85px; height: 30px; }
    .mob-logo-name { font-size: 16px; }
    .mobile-drawer { width: min(300px, calc(100vw - 32px)); }
    .drawer-user { margin: 10px 12px; padding: 12px; }
}

        /* ════════════════════════════
           MOBILE DRAWER
        ════════════════════════════ */
        .mobile-drawer {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 300px;
            z-index: 300;
            transform: translateX(-100%);
            transition: transform .38s cubic-bezier(.4,0,.2,1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            background:
                radial-gradient(circle at top left, rgba(212,175,55,0.12), transparent 50%),
                #0f0f0f;
            border-right: 1px solid rgba(212,175,55,0.2);
        }

        .mobile-drawer.open { transform: translateX(0); }

        /* Drawer header */
        .drawer-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 18px 16px;
            border-bottom: 1px solid rgba(212,175,55,0.15);
            flex-shrink: 0;
        }

        .drawer-brand { display: flex; align-items: center; gap: 12px; }

        .drawer-brand img {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #d4af37;
            box-shadow: 0 0 16px rgba(212,175,55,0.25);
        }

        .drawer-brand-name {
            font-size: 18px;
            font-weight: 800;
            background: linear-gradient(to right, #d4af37, #f8e08e, #b8860b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 22px;
            border: 1px solid rgba(212,175,55,0.2);
            background: rgba(255,255,255,0.08);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
            backdrop-filter: blur(10px);
        }

        .topbar-brand-logo {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            object-fit: cover;
            border: 2px solid #d4af37;
        }

        .topbar-brand-name {
            font-size: 1rem;
            font-weight: 800;
            color: #f8e08e;
            letter-spacing: 0.02em;
        }

        .topbar-brand-sub {
            font-size: 11px;
            color: #d1d5db;
            text-transform: uppercase;
            letter-spacing: .12em;
        }

        .drawer-brand-sub {
            font-size: 9px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: .12em;
        }

        .drawer-close {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(212,175,55,0.1);
            border: 1px solid rgba(212,175,55,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #d4af37;
            font-size: 15px;
            transition: background .2s;
            flex-shrink: 0;
        }

        .drawer-close:hover { background: rgba(212,175,55,0.2); }

        /* Drawer user card */
        .drawer-user {
            margin: 14px 16px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,215,0,0.15);
            border-radius: 18px;
            flex-shrink: 0;
        }

        .drawer-user img {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #d4af37;
            flex-shrink: 0;
        }

        .drawer-user-name { font-size: 14px; font-weight: 700; color: #fff; }
        .drawer-user-role { font-size: 11px; color: #d4af37; }

        /* Drawer scroll area */
        .drawer-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 8px 14px 0;
            scrollbar-width: thin;
            scrollbar-color: rgba(212,175,55,0.3) transparent;
        }

        .drawer-scroll::-webkit-scrollbar { width: 4px; }
        .drawer-scroll::-webkit-scrollbar-track { background: transparent; }
        .drawer-scroll::-webkit-scrollbar-thumb {
            background: rgba(212,175,55,0.3);
            border-radius: 4px;
        }

        /* Drawer nav link (reuse .nav-link style) */
        .drawer-nav-link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 16px;
            border-radius: 14px;
            color: #d1d5db;
            font-weight: 500;
            font-size: 14px;
            text-decoration: none;
            transition: all .2s;
            margin-bottom: 3px;
        }

        .drawer-nav-link i { width: 18px; text-align: center; }

        .drawer-nav-link:hover {
            background: linear-gradient(to right, rgba(212,175,55,0.18), rgba(255,255,255,0.04));
            color: #fff;
            transform: translateX(4px);
        }

        .drawer-nav-link.active {
            background: linear-gradient(to right, #d4af37, #f5d76e);
            color: #111827;
            box-shadow: 0 8px 24px rgba(212,175,55,0.3);
            font-weight: 700;
        }

        /* Drawer footer */
        .drawer-foot {
            padding: 14px 16px;
            border-top: 1px solid rgba(212,175,55,0.15);
            flex-shrink: 0;
        }

        aside {
            overflow-y: auto;
        }

        html, body {
            overflow-x: hidden;
        }

        img,
        table,
        canvas,
        .chart-container {
            max-width: 100%;
        }

        /* ════════════════════════════
           RESPONSIVE
        ════════════════════════════ */
        @media (max-width: 768px) {
            aside { display: none !important; }
            .mob-topbar { display: flex; }
            .drawer-overlay { display: block; }
        }

        /* Tables responsive */
        .table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .admin-card { overflow-x: auto; }

        @media (max-width: 640px) {
            .content { padding: 12px !important; }
            .mob-topbar { padding: 12px 14px; }
            .mob-logo-name { font-size: 16px; }
            /* Force Tailwind grid cols to full width */
            .grid-cols-2, .grid-cols-3, .grid-cols-4 { grid-template-columns: 1fr !important; }
            /* Bootstrap cols */
            .row.g-4 > [class*="col-md"],
            .row.g-3 > [class*="col-md"] { width: 100% !important; flex: 0 0 100% !important; max-width: 100% !important; }
        }

        @media (max-width: 400px) {
            .mob-topbar { padding: 10px 12px; }
            .mob-burger { width: 36px; height: 36px; font-size: 16px; }
        }
    </style>
<style>
/* ══════════════════════════════════════════════════════
   DARK THEME — Client Dashboard
══════════════════════════════════════════════════════ */
body { background: #0d0b1a !important; color: #fff !important; padding-top: 78px !important; }

::-webkit-scrollbar-track { background: #0d0b1a; }
::-webkit-scrollbar-thumb { background: rgba(233,30,140,.25) !important; border-radius: 20px; }

/* Sidebar */
aside.glass {
    background: #160d2a !important; backdrop-filter: none !important;
    border-right: 1px solid rgba(233,30,140,.1) !important;
    border-top: none !important; border-bottom: none !important;
}

/* ── Profile card ── */
.clt-profile-card { padding: 18px 16px; border-bottom: 1px solid rgba(255,255,255,.06); flex-shrink: 0; }
.clt-profile-inner {
    display: flex; align-items: center; gap: 12px; padding: 14px; border-radius: 20px;
    background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.06);
}
.clt-profile-avatar {
    width: 54px; height: 54px; border-radius: 50%; object-fit: cover; flex-shrink: 0;
    border: 2px solid rgba(233,30,140,.5); box-shadow: 0 0 14px rgba(233,30,140,.2);
}
.clt-profile-name { font-size: 14px; font-weight: 700; color: #fff; line-height: 1.2; }
.clt-profile-email { font-size: 11px; color: rgba(255,255,255,.38); margin-top: 3px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 140px; }
.clt-profile-badge {
    display: inline-flex; align-items: center; gap: 4px; margin-top: 4px;
    padding: 3px 10px; border-radius: 999px;
    background: rgba(233,30,140,.18); border: 1px solid rgba(233,30,140,.3);
    font-size: 9px; font-weight: 700; color: #ff6ab4; text-transform: uppercase; letter-spacing: .06em;
}

/* ── Promo card ── */
.clt-sidebar-promo {
    margin: 0 12px 14px; padding: 16px;
    background: linear-gradient(135deg, #3d1060, #2d0850);
    border: 1px solid rgba(233,30,140,.22); border-radius: 18px; flex-shrink: 0;
}
.clt-sidebar-promo-title { font-size: 13px; font-weight: 800; color: #fff; margin-bottom: 5px; }
.clt-sidebar-promo-desc { font-size: 10px; color: rgba(255,255,255,.5); line-height: 1.5; margin-bottom: 10px; }
.clt-sidebar-promo-btn {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    width: 100%; padding: 9px; background: linear-gradient(135deg, #e91e8c, #c0156d);
    border: none; border-radius: 10px; color: #fff; font-size: 11px; font-weight: 700;
    cursor: pointer; text-decoration: none; transition: all .2s;
}
.clt-sidebar-promo-btn:hover { color: #fff; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(233,30,140,.35); }

/* ── Nav links ── */
.nav-link { color: rgba(255,255,255,.55) !important; font-size: 13px !important; }
.nav-link:hover { color: #fff !important; background: rgba(255,255,255,.07) !important; transform: translateX(3px) !important; }
.nav-link.active { color: #fff !important; background: linear-gradient(135deg, #e91e8c, #c0156d) !important; box-shadow: 0 4px 18px rgba(233,30,140,.3) !important; }

/* Notification badge */
.nav-notif-badge {
    margin-left: auto; background: #e91e8c; color: #fff;
    font-size: 10px; font-weight: 800; min-width: 20px; height: 20px;
    border-radius: 10px; display: flex; align-items: center; justify-content: center; padding: 0 5px;
}

/* ── Logout ── */
.btn-gold { background: rgba(239,68,68,.1) !important; border: 1px solid rgba(239,68,68,.2) !important; color: rgba(239,68,68,.8) !important; box-shadow: none !important; }
.btn-gold:hover { background: rgba(239,68,68,.18) !important; color: #EF4444 !important; transform: none !important; box-shadow: none !important; }

/* ── Topbar salon image ── */
.topbar-salon-img {
    width: 52px; height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 2.5px solid rgba(233,30,140,.5);
    box-shadow: 0 0 0 3px rgba(233,30,140,.12), 0 4px 14px rgba(0,0,0,.35);
    flex-shrink: 0;
    margin-left: auto;
    transition: transform .3s, box-shadow .3s;
}
.topbar-salon-img:hover {
    transform: scale(1.07);
    box-shadow: 0 0 0 4px rgba(233,30,140,.3), 0 6px 20px rgba(0,0,0,.45);
}
@media(max-width:640px) { .topbar-salon-img { width: 40px; height: 40px; } }

/* ── Desktop topbar ── */
.desktop-header.glass { background: #160d2a !important; backdrop-filter: none !important; border-bottom: 1px solid rgba(233,30,140,.1) !important; }
.desktop-header h1 { color: #fff !important; }
.premium-card { background: #1a1235 !important; border: 1px solid rgba(233,30,140,.1) !important; backdrop-filter: none !important; }
.premium-card input { color: #fff !important; }
.premium-card input::placeholder { color: rgba(255,255,255,.3) !important; }
.text-yellow-400 { color: #e91e8c !important; }
.border-yellow-700\/20 { border-color: rgba(233,30,140,.12) !important; }

/* ── Mobile drawer ── */
.mobile-drawer { background: #160d2a !important; border-right: 1px solid rgba(233,30,140,.1) !important; }
.drawer-nav-link { color: rgba(255,255,255,.6) !important; }
.drawer-nav-link:hover { background: rgba(255,255,255,.07) !important; color: #fff !important; }
.drawer-nav-link.active { background: linear-gradient(135deg, #e91e8c, #c0156d) !important; color: #fff !important; }
.lang-switch { background: rgba(255,255,255,.08) !important; border: 1px solid rgba(255,255,255,.12) !important; color: #fff !important; }

/* ── Main content dark override ── */
main { background: transparent; color: #fff; }
main h1, main h2, main h3, main h4, main h5, main h6 { color: #fff !important; -webkit-text-fill-color: #fff !important; background: none !important; }
main p, main li, main small { color: rgba(255,255,255,.6) !important; }
main label { color: rgba(255,255,255,.65) !important; }
main input[type="text"], main input[type="email"], main input[type="password"],
main input[type="date"], main input[type="time"], main input[type="number"],
main input[type="tel"], main textarea, main select {
    color: #fff !important; background: rgba(255,255,255,.06) !important; border-color: rgba(255,255,255,.12) !important;
}
main input::placeholder, main textarea::placeholder { color: rgba(255,255,255,.3) !important; }
main table { color: #fff !important; }
main thead th { color: rgba(255,255,255,.9) !important; background: rgba(233,30,140,.1) !important; border-color: rgba(255,255,255,.08) !important; }
main td { color: rgba(255,255,255,.8) !important; border-color: rgba(255,255,255,.06) !important; }
main .premium-card, main .glass, main .card { background: #1a1235 !important; border: 1px solid rgba(233,30,140,.1) !important; backdrop-filter: none !important; color: #fff !important; }
main .card-body, main .card-header { background: transparent !important; color: #fff !important; border-color: rgba(255,255,255,.06) !important; }
main .text-white { color: #fff !important; }
main .text-gray-400, main .text-gray-500, main .text-gray-600 { color: rgba(255,255,255,.45) !important; }
main .text-gray-100, main .text-gray-200, main .text-gray-300 { color: rgba(255,255,255,.7) !important; }
main .alert-success { color: #4ade80 !important; background: rgba(74,222,128,.1) !important; border-color: rgba(74,222,128,.2) !important; }
main .alert-danger  { color: #f87171 !important; background: rgba(248,113,113,.08) !important; border-color: rgba(248,113,113,.2) !important; }
main .alert-warning { color: #fbbf24 !important; background: rgba(251,191,36,.08) !important; border-color: rgba(251,191,36,.2) !important; }

/* Dark card helper */
.dk-card { background: #1a1235; border: 1px solid rgba(233,30,140,.12); border-radius: 18px; padding: 22px; }
.dk-section-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
.dk-section-title { font-size: .95rem; font-weight: 700; color: #fff; margin: 0; }
.dk-link { font-size: .8rem; font-weight: 600; color: #e91e8c; text-decoration: none; }
.dk-link:hover { color: #ff6ab4; }
.dk-muted { color: rgba(255,255,255,.45) !important; }
</style>
@stack('styles')
</head>

<body>

{{-- ═══════════════════════════════════
     SHARED NAVBAR (homepage design)
════════════════════════════════════ --}}
@include('partials.main-navbar')

{{-- ═══════════════════════════════════
     MOBILE TOPBAR (hidden — replaced by shared navbar)
════════════════════════════════════ --}}
<div class="mob-topbar" style="display:none!important">
    <a href="{{ route('home') }}" class="mob-logo">
        <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair">
        <div>
            <div class="mob-logo-name">MAROL</div>
            <div class="mob-logo-sub">Hair</div>
        </div>
    </a>
    <button class="mob-burger" onclick="toggleDrawer()" aria-label="Ouvrir le menu">
        <i class="fa-solid fa-bars" id="burger-icon"></i>
    </button>
</div>

{{-- ═══════════════════════════════════
     OVERLAY
════════════════════════════════════ --}}
<div class="drawer-overlay" id="drawer-overlay" onclick="toggleDrawer()"></div>

{{-- ═══════════════════════════════════
     MOBILE DRAWER
════════════════════════════════════ --}}
<div class="mobile-drawer" id="mobile-drawer" role="navigation" aria-label="Menu principal">

    {{-- Header --}}
    <div class="drawer-head">
        <div class="drawer-brand">
            <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair">
            <div>
                <div class="drawer-brand-name">MAROL</div>
                <div class="drawer-brand-sub">Hair</div>
            </div>
        </div>
        <button class="drawer-close" onclick="toggleDrawer()" aria-label="Fermer">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    {{-- User card --}}
    @auth
    <div class="drawer-user">
        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=111827&color=d4af37"
             alt="Avatar">
        <div>
            <div class="drawer-user-name">{{ auth()->user()->name }}</div>
            <div class="drawer-user-role">✦ {{ __('messages.premium_client') }}</div>
        </div>
    </div>
    @else
    <div class="drawer-user" style="cursor: pointer;" onclick="window.location.href='{{ route('login') }}'">
        <div style="width:50px; height:50px; border-radius:50%; background:linear-gradient(135deg,#D4AF37,#F5D76E); display:flex; align-items:center; justify-content:center; color:#111827;">
            <i class="fa-solid fa-user"></i>
        </div>
        <div>
            <div class="drawer-user-name">{{ __('messages.login') }}</div>
            <div class="drawer-user-role">✦ {{ __('messages.guest') }}</div>
        </div>
    </div>
    @endauth

    {{-- Nav --}}
    <div class="drawer-scroll">
        @auth
        <a href="{{ route('home') }}"
           class="drawer-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i> {{ __('messages.nav_home') }}
        </a>
        <a href="{{ route('client.dashboard') }}"
           class="drawer-nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high"></i> {{ __('messages.dashboard') }}
        </a>
        <a href="{{ route('profile.show') }}"
           class="drawer-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="fa-regular fa-user"></i> {{ __('messages.my_information') }}
        </a>
        <a href="{{ route('client.reservations') }}"
           class="drawer-nav-link {{ request()->routeIs('client.reservations') ? 'active' : '' }}">
            <i class="fa-regular fa-calendar-check"></i> {{ __('messages.my_appointments') }}
        </a>
        <a href="{{ route('favorites.index') }}"
           class="drawer-nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}">
            <i class="fa-solid fa-heart"></i> {{ __('messages.my_favorites') }}
        </a>
        <a href="{{ route('client.addresses') }}"
           class="drawer-nav-link {{ request()->routeIs('client.addresses') ? 'active' : '' }}">
            <i class="fa-solid fa-location-dot"></i> {{ __('messages.my_addresses') }}
        </a>
        <a href="{{ route('client.payments') }}"
           class="drawer-nav-link {{ request()->routeIs('client.payments') ? 'active' : '' }}">
            <i class="fa-regular fa-credit-card"></i> {{ __('messages.my_payments') }}
        </a>
        @php $drawerUnread = auth()->user()->unreadNotifications()->count(); @endphp
        <a href="{{ route('client.notifications') }}"
           class="drawer-nav-link {{ request()->routeIs('client.notifications') ? 'active' : '' }}"
           style="display:flex;align-items:center;gap:6px;">
            <i class="fa-regular fa-bell"></i>
            <span style="flex:1;">{{ __('messages.my_notifications') }}</span>
            @if($drawerUnread > 0)
            <span class="nav-notif-badge">{{ $drawerUnread > 99 ? '99+' : $drawerUnread }}</span>
            @endif
        </a>
        <a href="{{ route('client.vip.plans') }}"
           class="drawer-nav-link {{ request()->routeIs('client.vip.*') ? 'active' : '' }}"
           style="background:linear-gradient(135deg,rgba(212,175,55,.12),rgba(245,215,110,.07));border:1px solid rgba(212,175,55,.25);margin-top:4px;">
            <i class="fa-solid fa-crown" style="color:#d4af37;"></i>
            <span style="background:linear-gradient(to right,#d4af37,#f8e08e,#b8860b);-webkit-background-clip:text;-webkit-text-fill-color:transparent;font-weight:700;">{{ __('messages.clt_vip_program') }}</span>
        </a>
        @else
        <a href="{{ route('login') }}" class="drawer-nav-link">
            <i class="fa-solid fa-right-to-bracket"></i> {{ __('messages.login') }}
        </a>
        <a href="{{ route('register') }}" class="drawer-nav-link">
            <i class="fa-solid fa-user-plus"></i> {{ __('messages.register') }}
        </a>
        @endauth
        
    </div>

    {{-- Footer --}}
    <div class="drawer-foot">
        @auth
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn-gold w-full rounded-2xl py-3 flex items-center justify-center gap-3">
                <i class="fa-solid fa-right-from-bracket"></i> {{ __('messages.logout') }}
            </button>
        </form>
        @endauth
    </div>

</div>

{{-- ═══════════════════════════════════
     LAYOUT PRINCIPAL
════════════════════════════════════ --}}
<div class="flex min-h-screen">

    {{-- ====== SIDEBAR DESKTOP (masquée < md) ====== --}}
    <aside class="fixed left-0 w-72 hidden md:flex flex-col z-40"
           style="top:78px;bottom:0;height:auto;overflow-y:auto;background:#1a1230;border-right:1px solid rgba(233,30,140,.1);">

        {{-- ── Profile card ── --}}
        <div class="clt-profile-card">
            @auth
            <div class="clt-profile-inner">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2d1854&color=e91e8c&bold=true&size=100"
                     class="clt-profile-avatar" alt="{{ auth()->user()->name }}">
                <div style="flex:1;min-width:0;">
                    <div class="clt-profile-name">{{ auth()->user()->name }}</div>
                    <div class="clt-profile-badge">✦ {{ __('messages.premium_client') }}</div>
                    <div class="clt-profile-email">{{ auth()->user()->email }}</div>
                </div>
            </div>
            @else
            <div class="clt-profile-inner">
                <div style="width:54px;height:54px;border-radius:50%;background:linear-gradient(135deg,#e91e8c,#c0156d);display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0;">
                    <i class="fa-solid fa-user" style="font-size:18px;"></i>
                </div>
                <div>
                    <div class="clt-profile-greeting">{{ __('messages.welcome') }}</div>
                    <div class="clt-profile-name">{{ __('messages.guest') }}</div>
                </div>
            </div>
            @endauth
        </div>

        {{-- ── Menu ── --}}
        <nav class="flex-1 overflow-y-auto" style="padding:14px 12px 8px;">
            @auth
            <a href="{{ route('home') }}"
               class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i> {{ __('messages.nav_home') }}
            </a>
            <a href="{{ route('client.dashboard') }}"
               class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> {{ __('messages.dashboard') }}
            </a>
            <a href="{{ route('profile.show') }}"
               class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="fa-regular fa-user"></i> {{ __('messages.my_information') }}
            </a>
            <a href="{{ route('client.reservations') }}"
               class="nav-link {{ request()->routeIs('client.reservations') ? 'active' : '' }}">
                <i class="fa-regular fa-calendar-check"></i> {{ __('messages.my_appointments') }}
            </a>
            <a href="{{ route('favorites.index') }}"
               class="nav-link {{ request()->routeIs('favorites.*') ? 'active' : '' }}">
                <i class="fa-solid fa-heart"></i> {{ __('messages.my_favorites') }}
            </a>
            <a href="{{ route('client.addresses') }}"
               class="nav-link {{ request()->routeIs('client.addresses') ? 'active' : '' }}">
                <i class="fa-solid fa-location-dot"></i> {{ __('messages.my_addresses') }}
            </a>
            <a href="{{ route('client.payments') }}"
               class="nav-link {{ request()->routeIs('client.payments') ? 'active' : '' }}">
                <i class="fa-regular fa-credit-card"></i> {{ __('messages.my_payments') }}
            </a>
            @php $navUnread = auth()->user()->unreadNotifications()->count(); @endphp
            <a href="{{ route('client.notifications') }}"
               class="nav-link {{ request()->routeIs('client.notifications') ? 'active' : '' }}"
               style="display:flex;align-items:center;gap:6px;">
                <span style="position:relative;display:inline-flex;align-items:center;">
                    <i class="fa-regular fa-bell"></i>
                    @if($navUnread > 0)
                    <span style="position:absolute;top:-7px;right:-9px;background:#e91e8c;color:#fff;font-size:9px;font-weight:800;min-width:16px;height:16px;border-radius:8px;display:flex;align-items:center;justify-content:center;padding:0 3px;">{{ $navUnread > 99 ? '99+' : $navUnread }}</span>
                    @endif
                </span>
                {{ __('messages.my_notifications') }}
            </a>
            <a href="{{ route('client.vip.plans') }}"
               class="nav-link {{ request()->routeIs('client.vip.*') ? 'active' : '' }}"
               style="background:@if(request()->routeIs('client.vip.*')) linear-gradient(135deg,#d4af37,#f5d76e) @else linear-gradient(135deg,rgba(212,175,55,.12),rgba(245,215,110,.07)) @endif;border:1px solid rgba(212,175,55,.25);margin-top:6px;">
                <i class="fa-solid fa-crown" style="color:#d4af37;"></i>
                <span style="@unless(request()->routeIs('client.vip.*')) background:linear-gradient(to right,#d4af37,#f8e08e,#b8860b);-webkit-background-clip:text;-webkit-text-fill-color:transparent; @endunless">{{ __('messages.clt_vip_program') }}</span>
            </a>
            @else
            <a href="{{ route('login') }}" class="nav-link">
                <i class="fa-solid fa-right-to-bracket"></i> {{ __('messages.login') }}
            </a>
            <a href="{{ route('register') }}" class="nav-link">
                <i class="fa-solid fa-user-plus"></i> {{ __('messages.register') }}
            </a>
            @endauth
        </nav>

        {{-- ── Logout + Promo ── --}}
        @auth
        <div style="padding:10px 12px 8px;border-top:1px solid rgba(255,255,255,.06);flex-shrink:0;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full btn-gold rounded-2xl py-3 flex items-center justify-center gap-2" style="font-size:13px;">
                    <i class="fa-solid fa-right-from-bracket"></i> {{ __('messages.logout') }}
                </button>
            </form>
        </div>

        {{-- <div class="clt-sidebar-promo">
            <div class="clt-sidebar-promo-title">🎁 Parrainez une amie</div>
            <div class="clt-sidebar-promo-desc">Et recevez 10% de réduction sur votre prochain rendez-vous !</div>
            <a href="#" class="clt-sidebar-promo-btn">
                <i class="fa-solid fa-gift"></i> Parrainer maintenant
            </a>
        </div> --}}
        @endauth

    </aside>

    {{-- ====== MAIN ====== --}}
    {{-- <div class="flex-1 flex flex-col"> --}}
<div class="flex-1 flex flex-col md:ml-72 min-w-0 overflow-x-hidden">
        @include('partials.promo-banner')

        {{-- Topbar desktop --}}
        <header class="desktop-header glass border-b border-yellow-700/20 px-4 md:px-6 py-4 flex justify-between items-center overflow-hidden">
            <div class="flex items-center gap-5">
           
            {{-- <div>
                <h1 class="text-3xl font-extrabold gold-text">@yield('page-title')</h1>
                <p class="text-sm text-gray-400 mt-1">{{ __('messages.welcome_premium_space') }}</p>
            </div> --}}
        </div>
            <div class="flex items-center gap-4">
                {{-- Search --}}
                <div class="hidden lg:flex items-center premium-card px-4 py-3 max-w-[280px] w-full">
                    <i class="fa-solid fa-magnifying-glass text-yellow-400"></i>
                    <input type="text"
                           placeholder="{{ __('messages.search_placeholder') }}"
                           class="ml-3 bg-transparent outline-none text-sm w-full text-white placeholder:text-gray-500">
                </div>


                <img src="{{ asset('images/C34.jpg') }}" alt="Marol Hair" class="topbar-salon-img">

                {{-- Notification --}}
                @auth
                @php $topbarUnread = auth()->user()->unreadNotifications()->count(); @endphp
                <a href="{{ route('client.notifications') }}" class="relative premium-card w-12 h-12 flex items-center justify-center hover:scale-105 transition" style="text-decoration:none;">
                    <i class="fa-regular fa-bell text-yellow-400 text-lg"></i>
                    @if($topbarUnread > 0)
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">{{ $topbarUnread > 99 ? '99+' : $topbarUnread }}</span>
                    @endif
                </a>
                @endauth
            </div>
        </header>

        {{-- Content --}}
        <main class="p-4 md:p-6 fade-in max-w-full overflow-x-hidden">

            @yield('content')

        </main>

    </div>

</div>

{{-- ═══════════════════════════════════
     SCRIPTS
════════════════════════════════════ --}}
<script>
    function toggleDrawer() {
        const drawer  = document.getElementById('mobile-drawer');
        const overlay = document.getElementById('drawer-overlay');
        const icon    = document.getElementById('burger-icon');

        const isOpen = drawer.classList.toggle('open');
        overlay.classList.toggle('visible', isOpen);
        icon.className = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
        document.body.style.overflow = isOpen ? 'hidden' : '';
    }

    // Ferme au resize vers desktop
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 980) {
            document.getElementById('mobile-drawer').classList.remove('open');
            document.getElementById('drawer-overlay').classList.remove('visible');
            document.getElementById('burger-icon').className = 'fa-solid fa-bars';
            document.body.style.overflow = '';
        }
    });

    // Ferme avec Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && document.getElementById('mobile-drawer').classList.contains('open')) {
            toggleDrawer();
        }
    });

</script>

@stack('scripts')
@include('partials.toast')
</body>
</html>