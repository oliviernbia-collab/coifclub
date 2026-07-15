<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Prestataire Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@600;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #0e0a1c;
            color: rgba(255,255,255,.85);
        }

        /* ════════════════════════════
           LAYOUT
        ════════════════════════════ */
        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* ════════════════════════════
           SIDEBAR DESKTOP
        ════════════════════════════ */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #0f172a, #111827);
            color: white;
            position: fixed;
            top: 78px;
            left: 0;
            bottom: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            z-index: 50;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 15px;
            margin-bottom: 20px;
            background: rgba(255,255,255,0.05);
            border-radius: 16px;
            backdrop-filter: blur(10px);
            flex-shrink: 0;
        }

        .logo-image {
            width: 70%;
            height: 70px;
            object-fit: cover;
            border-radius: 10%;
            box-shadow: 0 8px 20px rgba(233,231,231,0.25);
            transition: all 0.3s ease;
        }

        .logo-image:hover {
            transform: scale(1.08);
            box-shadow: 0 10px 25px rgba(255,77,109,0.4);
        }

        .user-card {
            background: rgba(255,255,255,0.05);
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 20px;
            flex-shrink: 0;
        }

        .role-badge { font-size: 12px; color: #94a3b8; }

        .menu { flex: 1; }

        .menu a {
            display: flex;
            gap: 10px;
            align-items: center;
            padding: 12px 14px;
            border-radius: 12px;
            color: #cbd5e1;
            text-decoration: none;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: 0.25s;
        }

        .menu a i { width: 18px; text-align: center; }

        .menu a:hover {
            background: #1e293b;
            color: white;
            transform: translateX(4px);
        }

        .menu a.active {
            background: #ff3d71;
            color: white;
            box-shadow: 0 8px 20px rgba(255,61,113,0.3);
        }

        .btn-logout {
            background: linear-gradient(135deg, #ff3d71, #ff6b8a);
            border: none;
            color: white;
            border-radius: 12px;
            padding: 11px 16px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 14px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: 0.2s;
            cursor: pointer;
        }

        .btn-logout:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 25px rgba(255,61,113,0.35);
        }

        /* ════════════════════════════
           MAIN CONTENT
        ════════════════════════════ */
        .main {
            margin-left: 280px;
            width: 100%;
        }

        .topbar {
            background: white;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .content { padding: 25px; }

        .card-pro {
            background: white;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid #eef2ff;
        }

        /* ════════════════════════════
           MOBILE TOPBAR
        ════════════════════════════ */
        .mob-topbar {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 14px 18px;
            background: white;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .mob-logo {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mob-logo img {
            width: 90px;
            height: 34px;
            object-fit: contain;
            border: 2px solid #ff3d71;
        }

        .mob-logo-name {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.1;
        }

        .mob-logo-sub {
            font-size: 10px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .1em;
        }

        .mob-burger {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            background: #fff0f4;
            border: 1px solid #ffc2d0;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #ff3d71;
            font-size: 17px;
            transition: background .2s;
            flex-shrink: 0;
        }

        .mob-burger:hover { background: #ffe0e8; }

        /* ════════════════════════════
           OVERLAY
        ════════════════════════════ */
        .drawer-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15,23,42,0.6);
            z-index: 200;
            opacity: 0;
            transition: opacity .3s;
            backdrop-filter: blur(3px);
            -webkit-backdrop-filter: blur(3px);
        }

        .drawer-overlay.visible { opacity: 1; }

        /* ════════════════════════════
           MOBILE DRAWER
        ════════════════════════════ */
        .mobile-drawer {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 290px;
            background: linear-gradient(180deg, #0f172a 0%, #111827 100%);
            border-right: 1px solid rgba(255,61,113,0.15);
            z-index: 300;
            transform: translateX(-100%);
            transition: transform .36s cubic-bezier(.4,0,.2,1);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .mobile-drawer.open { transform: translateX(0); }

        /* Drawer head */
        .drawer-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 18px 18px 14px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }

        .drawer-brand { display: flex; align-items: center; gap: 12px; }

        .drawer-brand img {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #ff3d71;
            box-shadow: 0 0 14px rgba(255,61,113,0.25);
        }

        .drawer-brand-name {
            font-size: 15px;
            font-weight: 700;
            color: #f9fafb;
            line-height: 1.1;
        }

        .drawer-brand-sub {
            font-size: 10px;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .1em;
        }

        .drawer-close {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255,61,113,0.1);
            border: 1px solid rgba(255,61,113,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #ff3d71;
            font-size: 15px;
            transition: background .2s;
            flex-shrink: 0;
        }

        .drawer-close:hover { background: rgba(255,61,113,0.2); }

        /* Drawer user */
        .drawer-user {
            margin: 14px 16px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 16px;
            flex-shrink: 0;
        }

        .drawer-user img {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ff3d71;
            flex-shrink: 0;
        }

        .drawer-user-name { font-size: 14px; font-weight: 700; color: #f9fafb; }
        .drawer-user-role { font-size: 11px; color: #ff6b8a; }

        /* Drawer scroll */
        .drawer-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 8px 14px 0;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,61,113,0.3) transparent;
        }

        .drawer-scroll::-webkit-scrollbar       { width: 4px; }
        .drawer-scroll::-webkit-scrollbar-track { background: transparent; }
        .drawer-scroll::-webkit-scrollbar-thumb { background: rgba(255,61,113,0.3); border-radius: 4px; }

        /* Drawer links */
        .drawer-nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            color: #cbd5e1;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all .2s;
            margin-bottom: 4px;
        }

        .drawer-nav-link i { width: 18px; text-align: center; font-size: 15px; flex-shrink: 0; }

        .drawer-nav-link:hover {
            background: #1e293b;
            color: white;
            transform: translateX(4px);
        }

        .drawer-nav-link.active {
            background: #ff3d71;
            color: white;
            box-shadow: 0 8px 20px rgba(255,61,113,0.28);
        }

        /* Drawer footer */
        .drawer-foot {
            padding: 14px 16px;
            border-top: 1px solid rgba(255,255,255,0.07);
            flex-shrink: 0;
        }

        /* ════════════════════════════
           RESPONSIVE
        ════════════════════════════ */
        @media (max-width: 768px) {
            .sidebar      { display: none; }
            .main         { margin-left: 0; }
            .mob-topbar   { display: flex; }
            .topbar       { display: none; }
            .drawer-overlay { display: block; }
        }

/* ══════════════════════════════════════════════════════
   DARK THEME — Prestataire Panel (matches client design)
══════════════════════════════════════════════════════ */
body { background: #0e0a1c !important; color: rgba(255,255,255,.88) !important; padding-top: 78px !important; }

/* Sidebar pink accent fix */
.menu a.active { background: linear-gradient(135deg, #e91e8c, #c0156d) !important; box-shadow: 0 4px 18px rgba(233,30,140,.3) !important; }
.menu a:hover { background: rgba(255,255,255,.07) !important; }
.btn-logout { background: rgba(239,68,68,.1) !important; border: 1px solid rgba(239,68,68,.2) !important; color: rgba(239,68,68,.8) !important; box-shadow: none !important; }
.btn-logout:hover { background: rgba(239,68,68,.18) !important; color: #EF4444 !important; transform: none !important; box-shadow: none !important; }

/* Topbar → dark glass */
.topbar { background: rgba(14,10,28,.92) !important; box-shadow: 0 4px 24px rgba(0,0,0,.3) !important; border-bottom: 1px solid rgba(233,30,140,.12) !important; backdrop-filter: blur(20px) !important; }
.topbar h1, .topbar .topbar-title, .topbar strong { color: #fff !important; }
.topbar p, .topbar small, .topbar span { color: rgba(255,255,255,.5) !important; }

/* Card → dark glass */
.card-pro { background: rgba(255,255,255,.04) !important; border: 1px solid rgba(255,255,255,.08) !important; box-shadow: 0 4px 24px rgba(0,0,0,.25) !important; color: rgba(255,255,255,.85) !important; }

/* Mobile topbar → dark */
.mob-topbar { background: rgba(14,10,28,.95) !important; box-shadow: 0 4px 16px rgba(0,0,0,.3) !important; border-bottom: 1px solid rgba(233,30,140,.12) !important; }

/* Drawer pink fix */
.drawer-nav-link.active { background: linear-gradient(135deg, #e91e8c, #c0156d) !important; box-shadow: 0 4px 16px rgba(233,30,140,.3) !important; }
.drawer-nav-link:hover { background: rgba(255,255,255,.07) !important; }

/* Content text */
.content h1,.content h2,.content h3,.content h4,.content h5,.content h6 { color: #fff !important; -webkit-text-fill-color: #fff !important; background: none !important; }
.content p, .content li, .content small { color: rgba(255,255,255,.55) !important; }
.content label { color: rgba(255,255,255,.7) !important; }
.content .form-control, .content .form-select { color: #fff !important; background: rgba(255,255,255,.06) !important; border-color: rgba(255,255,255,.12) !important; }
.content .form-control::placeholder { color: rgba(255,255,255,.3) !important; }
.content .table, .content table { color: rgba(255,255,255,.85) !important; }
.content table thead th { color: rgba(255,255,255,.6) !important; background: rgba(233,30,140,.1) !important; border-bottom: 2px solid rgba(233,30,140,.2) !important; }
.content table td { color: rgba(255,255,255,.8) !important; border-color: rgba(255,255,255,.06) !important; }
.content table tbody tr:hover { background: rgba(255,255,255,.02) !important; }
.content .card-pro { background: rgba(255,255,255,.04) !important; border: 1px solid rgba(255,255,255,.08) !important; color: rgba(255,255,255,.85) !important; }
.content .card { background: rgba(255,255,255,.04) !important; border: 1px solid rgba(255,255,255,.08) !important; }
.content .card-body, .content .card-header { background: transparent !important; color: rgba(255,255,255,.85) !important; border-color: rgba(255,255,255,.06) !important; }
.content .text-muted { color: rgba(255,255,255,.45) !important; }
.content .alert-success { color: #4ade80 !important; background: rgba(74,222,128,.1) !important; border-color: rgba(74,222,128,.2) !important; }
.content .alert-danger  { color: #f87171 !important; background: rgba(248,113,113,.08) !important; border-color: rgba(248,113,113,.2) !important; }
.content .badge.bg-light, .content .badge-soft { background: rgba(233,30,140,.1) !important; color: #ff6ab4 !important; border: 1px solid rgba(233,30,140,.2) !important; }

::-webkit-scrollbar-track { background: #0e0a1c; }
::-webkit-scrollbar-thumb { background: rgba(233,30,140,.25); border-radius: 20px; }

/* ══ RESPONSIVE ══ */
@media (max-width: 980px) {
    .content { padding-bottom: 30px !important; }
}
@media (max-width: 768px) {
    .content table:not(.fc-scrollgrid):not(.noresponse) { display:block; overflow-x:auto; -webkit-overflow-scrolling:touch; white-space:nowrap; width:100%; }
    .content img:not(.logo-image) { max-width:100%; height:auto; }
}
@media (max-width: 640px) {
    .content { padding: 14px !important; }
    .row.g-4 > [class*="col-md"],
    .row.g-3 > [class*="col-md"] { width:100% !important; flex:0 0 100% !important; max-width:100% !important; }
    .svc-grid { grid-template-columns: 1fr !important; }
    .svc-stats { grid-template-columns: 1fr !important; }
    .plan-stats { grid-template-columns: 1fr !important; }
}

/* ══ GREEN SPINNER ══ */
@keyframes spin-green-p { to { transform: rotate(360deg); } }
.btn-spinner {
    display: inline-block;
    width: 16px; height: 16px;
    border: 2.5px solid rgba(34,197,94,.2);
    border-top-color:   #22c55e;
    border-right-color: #22c55e;
    border-radius: 50%;
    animation: spin-green-p .6s linear infinite;
    vertical-align: middle;
    margin-right: 6px;
    flex-shrink: 0;
}
.btn-submitting {
    opacity: .78 !important;
    pointer-events: none !important;
    cursor: not-allowed !important;
}
    </style>
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
    <div class="mob-logo">
        <img src="{{ asset('images/C4.jpg') }}" alt="Marol Hair">
        <div>
            <div class="mob-logo-name">Marol Hair</div>
            <div class="mob-logo-sub">Prestataire</div>
        </div>
    </div>
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
<div class="mobile-drawer" id="mobile-drawer" role="navigation" aria-label="Menu prestataire">

    {{-- Header --}}
    <div class="drawer-head">
        <div class="drawer-brand">
            <img src="{{ asset('images/C4.jpg') }}" alt="Marol Hair">
            <div>
                <div class="drawer-brand-name">Marol Hair</div>
                <div class="drawer-brand-sub">Espace Prestataire</div>
            </div>
        </div>
        <button class="drawer-close" onclick="toggleDrawer()" aria-label="Fermer">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    {{-- User --}}
    <div class="drawer-user">
        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=111827&color=ff3d71"
             alt="Avatar">
        <div>
            <div class="drawer-user-name">{{ auth()->user()->name }}</div>
            <div class="drawer-user-role"><i class="fa-solid fa-user-tie fa-xs"></i> Prestataire</div>
        </div>
    </div>

    {{-- Nav --}}
    <div class="drawer-scroll">
        <a href="{{ route('home') }}"
           class="drawer-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="fa-solid fa-house"></i> {{ __('messages.home') }}
        </a>
        <a href="{{ route('prestataire.dashboard') }}"
           class="drawer-nav-link {{ request()->routeIs('prestataire.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high"></i> {{ __('messages.dashboard') }}
        </a>
        <a href="#"
           class="drawer-nav-link {{ request()->routeIs('prestataire.salon*') ? 'active' : '' }}">
            <i class="fa-solid fa-store"></i> {{ __('messages.my_salon') }}
        </a>
        <a href="#"
           class="drawer-nav-link {{ request()->routeIs('prestataire.reservations*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-check"></i> {{ __('messages.reservations') }}
        </a>
        <a href="{{ route('prestataire.planning') }}"
           class="drawer-nav-link {{ request()->routeIs('prestataire.planning*') ? 'active' : '' }}">
            <i class="fa-solid fa-calendar-days"></i> {{ __('messages.planning') }}
        </a>
        <a href="#"
           class="drawer-nav-link {{ request()->routeIs('prestataire.revenus*') ? 'active' : '' }}">
            <i class="fa-solid fa-money-bill-trend-up"></i> {{ __('messages.revenues') }}
        </a>
        <a href="#"
           class="drawer-nav-link {{ request()->routeIs('prestataire.settings*') ? 'active' : '' }}">
            <i class="fa-solid fa-gear"></i> {{ __('messages.settings') }}
        </a>
        <div style="height:12px;"></div>
    </div>

    {{-- Footer --}}
    <div class="drawer-foot">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn-logout" type="submit">
                <i class="fa-solid fa-right-from-bracket"></i> {{ __('messages.logout') }}
            </button>
        </form>
    </div>

</div>

{{-- ═══════════════════════════════════
     LAYOUT PRINCIPAL
════════════════════════════════════ --}}
<div class="layout">

    {{-- SIDEBAR DESKTOP --}}
    <aside class="sidebar">

        <div class="sidebar-brand">
            <img src="{{ asset('images/C4.jpg') }}" alt="Logo Marol Hair" class="logo-image">
        </div>

        <div class="user-card">
            <div class="fw-bold">{{ auth()->user()->name }}</div>
            <div class="role-badge">
                <i class="fa-solid fa-user-tie"></i> Prestataire
            </div>
        </div>

        <div class="menu">
            <a href="{{ route('home') }}"
               class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i> {{ __('messages.home') }}
            </a>
            <a href="{{ route('prestataire.dashboard') }}"
               class="{{ request()->routeIs('prestataire.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> {{ __('messages.dashboard') }}
            </a>
            <a href="#"
               class="{{ request()->routeIs('prestataire.salon*') ? 'active' : '' }}">
                <i class="fa-solid fa-store"></i> {{ __('messages.my_salon') }}
            </a>
            <a href="#"
               class="{{ request()->routeIs('prestataire.reservations*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i> {{ __('messages.reservations') }}
            </a>
            <a href="{{ route('prestataire.planning') }}"
               class="{{ request()->routeIs('prestataire.planning*') ? 'active' : '' }}">
                <i class="fa-solid fa-calendar-days"></i> {{ __('messages.planning') }}
            </a>
            <a href="#"
               class="{{ request()->routeIs('prestataire.revenus*') ? 'active' : '' }}">
                <i class="fa-solid fa-money-bill-trend-up"></i> {{ __('messages.revenues') }}
            </a>
            <a href="#"
               class="{{ request()->routeIs('prestataire.settings*') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i> {{ __('messages.settings') }}
            </a>

            <div class="mt-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn-logout" type="submit">
                        <i class="fa-solid fa-right-from-bracket"></i> {{ __('messages.logout') }}
                    </button>
                </form>
            </div>
        </div>

    </aside>

    {{-- MAIN --}}
    <div class="main">

        {{-- TOPBAR DESKTOP --}}
        <div class="topbar">
            <h5 class="mb-0 fw-bold">@yield('title', 'Prestataire Dashboard')</h5>
            <div class="d-flex align-items-center gap-2">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=111827&color=ff3d71"
                     class="rounded-circle" width="40" alt="Avatar">
                <span class="fw-semibold text-dark">{{ auth()->user()->name }}</span>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="content">

            @yield('content')

        </div>

    </div>

</div>

{{-- ═══════════════════════════════════
     SCRIPTS
════════════════════════════════════ --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
        if (window.innerWidth > 768) {
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

<script>
/* ── Green spinner on form submit ── */
(function () {
    function attachSpinner(form) {
        form.addEventListener('submit', function () {
            var btn = form.querySelector('[type="submit"]:not([data-no-loading])');
            if (!btn || btn.disabled) return;
            var sp = document.createElement('span');
            sp.className = 'btn-spinner';
            btn.insertBefore(sp, btn.firstChild);
            btn.classList.add('btn-submitting');
            btn.disabled = true;
        });
    }
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('form').forEach(attachSpinner);
        if (window.innerWidth <= 768) {
            document.querySelectorAll('.content table:not(.fc-scrollgrid):not(.noresponse)').forEach(function (t) {
                if (t.closest('.table-responsive')) return;
                var w = document.createElement('div');
                w.style.cssText = 'overflow-x:auto;-webkit-overflow-scrolling:touch;width:100%;';
                t.parentNode.insertBefore(w, t);
                w.appendChild(t);
            });
        }
    });
})();
</script>

@include('partials.toast')
</body>
</html>

